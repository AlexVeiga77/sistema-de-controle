<?php
/**
 * Created by PhpStorm.
 * User: Veiga
 * Date: 28/06/2018
 * Time: 15:37
 */
namespace DoctrineMigrations;

use App\Entity\User;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180628153710 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;
    private $encoder;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->encoder = $container->get('security.password_encoder');
    }

    private function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    public function up(Schema $schema)
    {

        $entityManager = $this->getDoctrine()->getManager();


        $admin = new User();
        $admin

            ->setUsername('admin')
            ->setRoles(['ROLE_ADMINISTRADOR']);

        $password = $this->encoder->encodePassword($admin, 'admin123');

        $admin->setPassword($password);

        $entityManager->persist($admin);
        $entityManager->flush();
    }

    public function down(Schema $schema)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usuario = $entityManager->getRepository(User::class)->findByLogin('admin');

        $entityManager->remove($usuario);
        $entityManager->flush();
    }
}