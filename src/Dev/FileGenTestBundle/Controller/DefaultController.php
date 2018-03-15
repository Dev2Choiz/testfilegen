<?php

namespace Dev\FileGenTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
    * @Route(
    *     name="dev_filegen.default.index",
    *     path="/"
    * )
    */
    public function indexAction()
    {
        ini_set('max_execution_time', 300);
        $svc = $this->get('file_gen_test.compare');

        $stats = [];
        $tabNbLine = [10, 20, 40, 50, 100, 500];
        foreach ($tabNbLine as $nbLine) {
            $svc->setNbLine($nbLine);
            $svc->write();
            $result = $svc->read();
            $stats [$nbLine] = $result;
        }

        return $this->render('DevFileGenTestBundle:Default:index.html.twig', array(
            'stats' => $stats,
        ));
    }
}
