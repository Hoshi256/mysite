<?php

namespace App\Controller;

use App\Service\SendMailService;
use App\Repository\UserRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResetPasswordRequestFormType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
     
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
       

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
       
       
        return $this->redirectToRoute('app_home');
    }

    //reinitialiser mot passe

        #[Route(path: '/oubli-pass', name: 'forgotten_password')]


        public function forgottenPassword(
        Request $request,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $entityManager,
        SendMailService $mail
        
        ) : Response

        {
               
            $form = $this->createForm(ResetPasswordRequestFormType::class);
             $form->handleRequest($request);

             if($form->isSubmitted()&& $form->isValid()) {
                $user = $userRepository->findOneByEmail($form->get('email')->getData());
                if($user) {
                    $token = $tokenGenerator->generateToken();
                    $user->setResetToken($token);
                    $user->setResetToken($token);
                    $entityManager->flush();

                    // On génère un lien de réinitialisation du mot de passe
                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
// dd($url);
                    // On crée les données du mail
                $context = compact('url', 'user');

                    // Envoi du mail
                // $mail->send(
                //     'daniela.puscoiu@gmail.com',
                //     $user->getEmail(),
                //     'Réinitialisation de mot de passe',
                //     'password_reset',
                //     $context
                // );

            //   dd($mail);

        $mail = new PHPMailer(true);
        try {
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'daniela.puscoiu@gmail.com';                     //SMTP username
        $mail->Password   = 'yupppwccfpbaigsn'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged 
        

        $mail->setFrom('your-email@gmail.com', 'Your Name');
        $mail->addAddress($user->getEmail(), $user->getFirstName());     
 
         $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Réinitialisation de mot de passe';
    $mail->Body    = $this->renderView('emails/password_reset.html.twig', $context);
         $mail->send();
                } catch (Exception $e) {

                }

                $this->addFlash('success', 'Email envoyé avec succès');
                return $this->redirectToRoute('app_login');

                }

                // $user est null
                $this->addFlash('danger', 'Un problème est survenu');
                return $this->redirectToRoute('app_login');

             }


             return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);

        }


        // anoter route

            #[Route('/oubli-pass/{token}', name:'reset_pass')]

          public function resetPass(
            string $token,
        Request $request,
        UserRepository $usersRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
          ) : Response


          {
        // On vérifie si on a ce token dans la base
        $user = $usersRepository->findOneByResetToken($token);

            if ($user) {
                $form = $this->createForm(ResetPasswordFormType::class);
                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                 $user->setResetToken('');
                 $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                    );

                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash('success', 'Mot de passe changé avec succès');
                    return $this->redirectToRoute('app_login');


                }

                 return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);

            }

        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');
          }

    
}
