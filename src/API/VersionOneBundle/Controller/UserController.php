<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace API\VersionOneBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;
use Symfony\Component\HttpFoundation\Request;
use API\VersionOneBundle\APIObjects\User;
use API\VersionOneBundle\APIObjects\UserProperty;
use API\VersionOneBundle\Mappers\Database\UserDataTransfer;
use API\VersionOneBundle\Helper\OutputHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of UserController
 *
 * @author student
 */

class UserController extends FOSRestController
{
    /**
     * Gets a list of users
     * @FOS\View(
     *  serializerGroups={"user_list"},
     * )
     * @ApiDoc(output={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *           },
     *           "groups" = {"user_list"}
     *       })      
     */
    public function getUsersAction(Request $request)
    {

        $users = $this->get('api_version_one.mappers.database.userdatatransfer')->getUsers();
        return  ['users' => $users];
    }
    
    
    /**
     * Get a single user  
     * @ApiDoc(output={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *           },
     *           "groups" = {"full_user"}
     *       })    
     * @FOS\View(
     *  serializerGroups={"full_user"}
     * )   
     * @param int $userId the id of the user
     * @return User
     */
    public function getUserAction(Request $request, $userId)
    {
        $user = $this
                ->get('api_version_one.mappers.database.userdatatransfer')
                ->getSingleUser($userId);
        return  ['users' => $user];

    }
    
    /**
     * Creates a user
     * @ApiDoc(input={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *           },
     *           "groups" = {"adduser"}
     *          },
     *          output={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *           },
     *           "groups" = {"full_user"}
     *       })      
     * @return User
     */
    public function postUserAction(Request $request)
    {
        $adduser = $this->createForm('adduser');
        $userSerial = json_decode(json_encode($request->request->all()), true);
        $adduser->submit($userSerial);
        if(!$adduser->isValid())
        {
           $errors = $this->get('noahglaser.validation.formservices.getformerrors')->getAllFormErrors($adduser);
           return ['errors' => OutputHelper::formatFormError($errors, 'adduser')];
        }
        
        $newUser = $this
                    ->get("api_version_one.mappers.database.userdatatransfer")
                    ->createUser($adduser->getData());
        
        $user = $this
                ->get('api_version_one.mappers.database.userdatatransfer')
                ->getSingleUser($newUser->getId());
        
                
        $mailer = $this->get('mailer');
        $message = $mailer->createMessage()
        ->setSubject('Thanks for registering!')
        ->setFrom('glaserpower@gmail.com')
        ->setTo($user->getEmail())
        ->setBody(
            $this->renderView('APIVersionOneBundle:Email:activateUser.html.twig'),
            'text/html'
        );
        $mailer->send($message);
        
        
        return $user;

    }
    
    /**
     * Activates the user with id and the secret key
     * @ApiDoc()
     * @param int $userId the user id
     * @param string $secretCode this is the secret code sent with the link
     * @return array
     */
    public function patchActivateUserAction(Request $request, $userId, $secretCode)
    {
          if(!$this
                  ->get("api_version_one.mappers.database.userdatatransfer")
                  ->activateUser($userId, $secretCode))
          {
              return new Response('no user found', 404);
          }

        return array('success' => true);

    }
        
    /**
     * Sends the email with a reset password.
     * @ApiDoc(input={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *           },
     *           "groups" = {"resetpassword"}
     *          })
     * @return array
     */
    public function patchSendResetPasswordAction(Request $request)
    {
                
        $email = $request->get('email');
        if(!$this
                ->get("api_version_one.mappers.database.userdatatransfer")
                ->sendResetPassword($email))
        {
              return new Response('no user found', 404);
        }
        
        $mailer = $this->get('mailer');
        $message = $mailer->createMessage()
        ->setSubject('Password Reset!')
        ->setFrom('glaserpower@gmail.com')
        ->setTo($email)
        ->setBody(
            $this->renderView('APIVersionOneBundle:Email:resetPassword.html.twig'),
            'text/html'
        );
        $mailer->send($message);

        return array('success' => true);
    }
    
    
    /**
     * Resets the the password.
     * @ApiDoc(parameters={
     *      {"name"="email", "dataType"="string", "required"=true, "description"="The email address of the user"},
     *      {"name"="plainpassword", "dataType"="string", "required"=true, "description"="The new password, it must be between 8 to 16 characaters."},
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="The user id"},
     *      {"name"="secretCode", "dataType"="string", "required"=true, "description"="The secret code generated after the request"},
     *  })     
     * @return array
     */
    public function patchResetPasswordAction(Request $request)
    {
        
        
        $isPasswordInvalid = $this->isPasswordInValid($request->get('plainpassword'));
        $email = $request->get('email');
        $secretCode = $request->get('secretCode');
        $userId = $request->get('id');
        
        if($isPasswordInvalid !== false)
        {
            return $isPasswordInvalid;
        }
        
        
        if(!$this
                ->get("api_version_one.mappers.database.userdatatransfer")
                ->resetPassword($userId, $email, $isPasswordInvalid, $secretCode))
        {
              return new Response('no user found ', 404);
        }

        return array('success' => true);
    }
    
    /** 
     * Changes the user object, the user is required to login
     * @ApiDoc(parameters={
     *      {"name"="email", "dataType"="string", "required"=false, "description"="The email address of the user"},
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="The user id"},
     *      {"name"="username", "dataType"="string", "required"=true, "description"="The username of the user"}, 
     *      {"name"="properties[][id]", "dataType"="integer", "required"=true, "description"="The id of the property you are trying to change"},
     *      {"name"="properties[][value]","dataType"="string", "required"=true, "description"="The value of the property you are trying to change"},     *      
     * },
     * filters={
     *      {"name"="apikey", "dataType"="string"}
     * },
     * output={
     *           "class"   = "API\VersionOneBundle\APIObjects\User",
     *           "parsers" = {
     *               "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *           },
     *           "groups" = {"full_user"}
     *       })    

     * @param int $userId The user id
     * @return User
     */
    public function patchUserAction(Request $request, $userId)
    {
        
        $userSerial = json_decode(json_encode($request->request->all()), true);

        //We use the request because we want the user we are edit and not the url userid.
        $user = $this->getDoctrine()->getRepository('APIDatabaseBundle:User')->find($userSerial['id']);
                
        if(!$this->container->get('security.authorization_checker')->isGranted('user_edit', $user))
        {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
        }
        
        $userAPI = $this
                ->get('api_version_one.mappers.database.userdatatransfer')
                ->getSingleUser($user->getId());

        
        $edituser = $this->createForm('edituser', $userAPI);
        $edituser->submit($userSerial);
        if(!$edituser->isValid())
        {
           $errors = $this->get('noahglaser.validation.formservices.getformerrors')->getAllFormErrors($edituser);
           return ['errors' => OutputHelper::formatFormError($errors, 'edituser')];            
        }
        
        return $this->get('api_version_one.mappers.database.userdatatransfer')->updateUser($user, $edituser->getData());
        
        
    }
    
    private function isPasswordInValid($password)
    {
        
        $notblank = new NotBlank();
        $notblank->message = "password_not_blank";
        
        $notblankError = $this->get('validator')->validate($password, $notblank);
        if(count($notblankError) > 0)
        {
            return array('errors' => array('plainpassword' => $notblank->message));
        }
        
        $length = new Length(array('min' => 8 , 'max' => 16));        
        
        $lengthError = $this->get('validator')->validate($password, $length);
        if(count($lengthError) > 0)
        {
            return array('errors' => array('plainpassword' => "password_length"));
        }
        
        return false;
    }
    
    
    
   
    
    
}
