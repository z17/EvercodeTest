<?php
class Model_Main extends Model
{
    public function get_data()
    {				
		// определяем номер страницы
		$url = $_SERVER['REQUEST_URI'];
        $url = substr($url, strpos($url, '?'), strlen($url) - strpos($url, '?'));
		$routes = explode('/', $url);
		if ($_SERVER['REQUEST_URI'] == '/' or $_SERVER['REQUEST_URI'] == '/main')
		{
			$page = 1;
		}
		else
		{
			if (is_numeric($routes[2])) {
				$page = $routes[2];
			}
			elseif ($routes[2] != NULL) {
				Route::ErrorPage404();
			}
			else {
				$page = 1;
			}
		}
				
		$n = $this -> base -> countPosts();
		$postsOnPage = $this->numPosts;
		
		$postStart = ($page - 1)*$postsOnPage;
		$numPages = ceil($n/$postsOnPage);	
		
		$posts = $this -> base -> getPosts($postStart, $postsOnPage);
		if ($page > $numPages)
		{
			Route::ErrorPage404();
		}
		
		$data['title'] = 'Главная страница';
		$data['posts'] = $posts;
		$data['page'] = $page;
		$data['maxpage'] = $numPages;
		return $data;
    }
}