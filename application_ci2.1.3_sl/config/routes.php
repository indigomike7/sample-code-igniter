<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "homepage";
$route['404_override'] = '';

$route['university/(:any)/program/(:any)/course/(:any)/add_review'] = 'home/review/add_course_review/$1';
$route['university/(:any)/program/(:any)/course/(:any)/all_review'] = 'home/review/all_course_review/$1';
$route['university/(:any)/program/(:any)/course/(:any)'] = 'home/university/course/$3';
$route['university/(:any)/program/(:any)/add_review'] = 'home/review/add_program_review/$1';
$route['university/(:any)/program/(:any)/all_review'] = 'home/review/all_program_review/$1';
$route['university/(:any)/program/(:any)'] = 'home/university/program/$2';
$route['university/(:any)/add_review'] = 'home/review/add_university_review/$1';
$route['university/(:any)/all_review'] = 'home/review/all_university_review/$1';
$route['university/(:any)'] = 'home/university/detail/$1';

$route['page/(:any)'] = 'home/page/get_page/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */