<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Model
*
* Author:  Ben Edmunds
* 		   ben.edmunds@gmail.com
*	  	   @benedmunds
*
* Added Awesomeness: Phil Sturgeon
*
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  10.01.2009
*
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
*
* Requirements: PHP5 or above
*
*/

class Country_model extends CI_Model
{
    /**
        * Holds an array of tables used
        *
        * @var string
        **/
    public $tables = array();

    /**
        * activation code
        *
        * @var string
        **/
    public $activation_code;

    /**
        * forgotten password key
        *
        * @var string
        **/
    public $forgotten_password_code;

    /**
        * new password
        *
        * @var string
        **/
    public $new_password;

    /**
        * Identity
        *
        * @var string
        **/
    public $identity;

    /**
        * Where
        *
        * @var array
        **/
    public $_where = array();

    /**
        * Select
        *
        * @var string
        **/
    public $_select = array();

    /**
        * Like
        *
        * @var string
        **/
    public $_like_index ;
    /**
        * Like
        *
        * @var string
        **/
    public $_like_value ;

    /**
        * Limit
        *
        * @var string
        **/
    public $_limit = NULL;

    /**
        * Offset
        *
        * @var string
        **/
    public $_offset = NULL;

    /**
        * Order By
        *
        * @var string
        **/
    public $_order_by = NULL;

    /**
        * Order
        *
        * @var string
        **/
    public $_order = NULL;

    /**
        * Hooks
        *
        * @var object
        **/
    protected $_hooks;

    /**
        * Response
        *
        * @var string
        **/
    protected $response = NULL;

    /**
        * message (uses lang file)
        *
        * @var string
        **/
    protected $messages;

    /**
        * error message (uses lang file)
        *
        * @var string
        **/
    protected $errors;

    /**
        * error start delimiter
        *
        * @var string
        **/
    protected $error_start_delimiter;

    /**
        * error end delimiter
        *
        * @var string
        **/
    protected $error_end_delimiter;

    /**
        * caching of users and their groups
        *
        * @var array
        **/
    public $_cache_user_in_group = array();

    /**
        * caching of groups
        *
        * @var array
        **/
    protected $_cache_groups = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
//        $this->load->config('admin_ion_auth', TRUE);
        $this->load->helper('cookie');
        $this->load->helper('date');
        $this->load->library('session');
//        $this->lang->load('region');

        //initialize db tables data
        $this->tables  = array('country'=>'countries','sub_region'=>'sub_regions');

        //initialize data
        $this->identity_column = 'country_id';
        $this->join='sr_id';

        $this->_region_hooks = new stdClass;


        //initialize messages and error
        $this->messages = array();
        $this->errors = array();
        $this->message_start_delimiter = "<p>";
        $this->message_end_delimiter   = "</p>";
        $this->error_start_delimiter   = "<p>";
        $this->error_end_delimiter     = "</p>";



        $this->trigger_events('model_constructor');
    }
    public function trigger_events($events)
    {
        if (is_array($events) && !empty($events))
        {
            foreach ($events as $event)
            {
                    $this->trigger_events($event);
            }
        }
        else
        {
            if (isset($this->_hooks->$events) && !empty($this->_hooks->$events))
            {
                    foreach ($this->_hooks->$events as $name => $hook)
                    {
                            $this->_call_hook($events, $name);
                    }
            }
        }
    }
    public function limit($limit)
    {
        $this->trigger_events('limit');
        $this->_limit = $limit;

        return $this;
    }

    public function offset($offset)
    {
        $this->trigger_events('offset');
        $this->_offset = $offset;

        return $this;
    }

    public function where($where, $value = NULL)
    {
        $this->trigger_events('where');

        if (!is_array($where))
        {
                $where = array($where => $value);
        }

        array_push($this->_where, $where);

        return $this;
    }

    public function like($like, $value = NULL)
    {
        $this->trigger_events('like');

        if (!is_array($like))
        {
                $like = array($like => $value);
        }

        array_push($this->_like, $like);

        return $this;
    }

    public function select($select)
    {
        $this->trigger_events('select');

        $this->_select[] = $select;

        return $this;
    }

    public function order_by($by, $order='desc')
    {
            $this->trigger_events('order_by');

            $this->_order_by = $by;
            $this->_order    = $order;

            return $this;
    }

    public function row()
    {
        $this->trigger_events('row');

        $row = $this->response->row();
        $this->response->free_result();

        return $row;
    }

    public function row_array()
    {
        $this->trigger_events(array('row', 'row_array'));

        $row = $this->response->row_array();
        $this->response->free_result();

        return $row;
    }

    public function result()
    {
        $this->trigger_events('result');

        $result = $this->response->result();
        $this->response->free_result();

        return $result;
    }

    public function result_array()
    {
        $this->trigger_events(array('result', 'result_array'));

        $result = $this->response->result_array();
        $this->response->free_result();

        return $result;
    }

    public function num_rows()
    {
        $this->trigger_events(array('num_rows'));

        $result = $this->response->num_rows();
        $this->response->free_result();

        return $result;
    }

    /**
        * admin_users
        *
        * @return object admin_users
        * @author Ben Edmunds
        **/
    public function countries($limit, $offset, $order_by,$order,$where,$like_index,$like_value)
    {
        $this->_limit = $limit;
        $this->_offset=$offset;
        $this->_like_index=$like_index;
        $this->_like_value=$like_value;
        $this->_where=$where;
        $this->_order_by=$order_by;
        $this->_order=$order;
        
        $this->trigger_events('countries');

        if (isset($this->_select))
        {
                foreach ($this->_select as $select)
                {
                        $this->db->select($select);
                }

                $this->_select = array();
        }
        else
        {
                //default selects
                $this->db->select(array(
                    $this->tables['country'].'.*',
                    $this->tables['sub_region'].'.*'
                ));
        }

        
        $this->db->distinct();

        $this->trigger_events('extra_where');

        //run each where that was passed
        if (isset($this->_where))
        {
            if(count($this->_where)>0 && is_array($this->_where))
            {
                foreach ($this->_where as $where)
                {
                        $this->db->where($where,NULL,FALSE);
                }
            }

                $this->_where = array();
        }

        if (($this->_like_index!="")&&($this->_like_value!=""))
        {
            $this->db->like($this->_like_index,$this->_like_value);
            $this->_like_index = null;
            $this->_like_value = null;
        }
//        echo $this->_limit." x y". $this->_offset;
        if (isset($this->_limit) && isset($this->_offset))
        {
                $this->db->limit( $this->_offset,$this->_limit);

                $this->_limit  = NULL;
                $this->_offset = NULL;
        }
        else if (isset($this->_limit))
        {
                $this->db->limit($this->_limit);

                $this->_limit  = NULL;
        }

        //set the order
        if (isset($this->_order_by) && isset($this->_order))
        {
                $this->db->order_by($this->_order_by, $this->_order);

                $this->_order    = NULL;
                $this->_order_by = NULL;
        }
        $this->db->join('sub_regions', 'sub_regions.sr_id = countries.sr_id','left');
        $this->response = $this->db->get($this->tables['country']);
//        echo $this->db->last_query();

        return $this;
    }
    public function count_countries()
    {
        
        $this->trigger_events('regions');
        $this->db->select(array(
            'count(*) as count'
            ));

        $this->trigger_events('extra_where');


        $this->response = $this->db->get($this->tables['country']);

        return $this;
    }
    public function delete($id)
    {
        $this->response = $this->db->query("delete from countries where country_id = '".$id."'");
        return $this;
    }
    public function insert($country_fips,$country_iso,$country_tld,$country_name,$sr_id)
    {
        $this->response = $this->db->query("insert into countries( 
            country_fips
            , country_iso
            , country_tld
            , country_name
            , sr_id
            ) 
            values
            ( 
            '".$country_fips."'
                ,'".$country_iso."'
                ,'".$country_tld."'
                ,'".$country_name."'
                ,'".$sr_id."'
             )");
        return $this;
    }
    public function update($country_fips,$country_iso,$country_tld,$country_name, $sr_id,$country_id)
    {
        $this->response = $this->db->query("update countries set 
                country_fips = '".$country_fips."'
                ,country_iso = '".$country_iso."'
                ,country_tld = '".$country_tld."'
                ,country_name = '".$country_name."'
                ,sr_id = '".$sr_id."'
                where country_id = '".$country_id."'");
        return $this;
    }
    public function all()
    {
        
        $this->trigger_events('regions');

        if (isset($this->_select))
        {
                foreach ($this->_select as $select)
                {
                        $this->db->select($select);
                }

                $this->_select = array();
        }
        else
        {
                //default selects
                $this->db->select(array(
                    $this->tables['country'].'.*'
                    ));
        }

        $this->response = $this->db->get($this->tables['country']);
//        echo $this->db->last_query();

        return $this;
    }
    
}
?>

