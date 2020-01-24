<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    // /**
    //  * @Route("/user", name="user")
    //  */
    // public function index()
    // {
    //     return $this->render('user/index.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('user/connectnav.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @route("/search",name="search")
     */
    public function search(Request $request){
        // dump($request);
       // $form_search = $this->createFormBuilder()
       //     ->add('title')
       //     ->getForm();
        //dump($form_search);
        //$form_search->handleRequest($request);
        // $task = new UserData();
        // 
        //  
        //dd($request);
        //if($form_search->isSubmitted() && $form_search->isValid()){
            // var_dump();
            //dd($form_search);
            $client = HttpClient::create();
            $response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie?api_key=0e7e05344bae7a1500412703f7775293&language=en-US&query='.$_POST['search'].'&page=1&include_adult=false');
            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            $content = $response->toArray();
            // print_r($content);
            // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
            // dd($content);
            return $this->render('user/search.html.twig',['movies'=>$content['results']]);
        //}
        return $this->render('base.html.twig');
    }
}
