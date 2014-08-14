<?php

namespace Arnaud\ToDoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Arnaud\ToDoBundle\Entity\Status;

class FixturesCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('arnaud:fixtures:load')
            ->setDescription('Load needed datas')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
            $start = time();
            $em = $this->getContainer()->get('doctrine')->getManager('default');

            $aStatus = array(array("Not started yet", "FF0000"), array("On progress", "FFA500"), array("Finished", "00FF00"));
            foreach ($aStatus as $status) {
                if (!$s = $em->getRepository('ArnaudToDoBundle:Status')->findOneByName($status[0])) {
                    $s = new Status();
                    $s->setName($status[0]);
                    $s->setColor($status[1]);
                    $em->persist($s);

                    $output->writeln("Add status (".$status[0].")");
                }
            }

            $em->flush();
            $now = time();
            $duration = $now - $start;

            $output->writeln("Fixtures exécutées en ".$duration." sec.");
    }
}
