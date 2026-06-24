<?php
class Router {
    private $routes = [];

    // Fungsi untuk mendaftarkan URL
    public function get($route, $action) {
        $this->addRoute('GET', $route, $action);
    }

    public function post($route, $action) {
        $this->addRoute('POST', $route, $action);
    }

    private function addRoute($method, $route, $action) {
        // Mengubah parameter dinamis (contoh: /games/:id) menjadi format regex
        $routeRegex = preg_replace('/:[a-zA-Z0-9_]+/', '([a-zA-Z0-9_]+)', $route);
        $this->routes[] = [
            'method' => $method,
            'route' => '#^' . $routeRegex . '$#',
            'action' => $action
        ];
    }

    // Fungsi untuk menjalankan rute yang cocok
    public function dispatch($url) {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = '/' . trim($url, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['route'], $url, $matches)) {
                array_shift($matches); // Hapus hasil kecocokan penuh dari regex

                // Pecah string action (contoh: "GameController@show")
                list($controller, $methodName) = explode('@', $route['action']);
                
                // Panggil file controllernya
                $controllerInstance = new $controller();
                
                // Eksekusi fungsinya dan kirimkan parameter (jika ada)
                call_user_func_array([$controllerInstance, $methodName], $matches);
                return;
            }
        }
        
        // Jika tidak ada URL yang cocok
        echo "<h1 style='text-align:center; margin-top:50px;'>404 - Halaman Tidak Ditemukan</h1>";
    }
}