<?php
namespace app\model;

use Phlib\Db\Adapter as DB;

class Route
{

    public function __construct($config){
        $this->db = new DB($config);
        $this->url = $this->getUri();
    }

    /**
     * @return string[]
     */
    public function getUrlAction(): array
    {
       if($this->url == ''){
           if(isset($_POST['set_url'])){
               $this->insertNewUrl($_POST['set_url']);
               return ['json' => 'Url Added'];
           }
            return ['index' => 'Home page'];
        }
       return $this->getActiveUrl();
    }

    /**
     * @return array|string[]
     */
    public function getActiveUrl(): array
    {
        $result = $this->db->query("SELECT * FROM urls WHERE url = ?  AND expire > NOW()",[$this->url]);
        if(!$result->rowCount()){
            return ['404' => 'Not Found'];
        }
        $result = $result->fetch();
        $this->updateViewed($result['id'],$result['viewed']+1);
        return ['page' => $result['viewed']];
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        $uri = substr($_SERVER['REQUEST_URI'], strlen($this->getBasePath()));

        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        return trim($uri, '/');
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)).'/';
    }

    public function insertNewUrl($url){
        if(isset($_POST['expired'])){
            $expired = date('Y-m-d H:i:s', strtotime($_POST['expired']));
        }else{
            $expired = date('Y-m-d H:i:s');
        }
        $this->db->delete('urls',"url = '".$url."'");
        $this->db->insert('urls',['url' => $url,'expire' => $expired]);
    }

    public function updateViewed($id,$new_viewed){
        $this->db->update('urls',['viewed' => $new_viewed],'id='.(int)$id);
    }

}