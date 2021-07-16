<?php
namespace app;
use app\model\Route;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Boot
{
    public $db;
    public $request;
    public $response;

    /**
     * Boot constructor.
     * @param $config
     */
    public function __construct($config){
        $this->request = new Route($config);
        $loader = new FilesystemLoader('./app/view');
        $this->response = new Environment($loader);
    }

    public function run()
    {
       $result =  $this->request->getUrlAction();
       foreach ($result as $key => $value){
           if($key == 'json'){
               header('Content-Type: application/json');
               echo json_encode(['success' => $value]);
               exit;
           }
           echo $this->response->render($key.'.html',['data' => $value]);
       }

    }


}