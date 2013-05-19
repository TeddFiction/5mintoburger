<?php

namespace FiveMinTo\BurgerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FiveMinTo\BurgerBundle\Entity\Burger;
use FiveMinTo\BurgerBundle\Entity\BurgerIngredient;
use FiveMinTo\BurgerBundle\Entity\Vote;
use FiveMinTo\BurgerBundle\Form\BurgerType;
use FiveMinTo\BurgerBundle\Form\BurgerIngredientType;

class AddBurgerController extends Controller
{
	public function addBurgerAction()
	{
		// On récupére l'EntityManager
		$em = $this->getDoctrine()->getManager();
		
		$burger = new Burger();

        $bi1 = new BurgerIngredient();
        $burger->addBurgerIngredient($bi1);
        $bi2 = new BurgerIngredient();
        $burger->addBurgerIngredient($bi1);

        $form = $this->createForm(new BurgerType(), $burger);
		
		$request = $this->getRequest();
    	if($request->isMethod('POST')){
	    	$form->bindRequest($request);	    	
	    	$burger = $form->getData();
	    		    
	    	$em->persist($burger->getVote());
	    	$em->flush();
	    		  
	    	$em->persist($burger);
	    	$em->flush();  	
	    	
	    	foreach($burger->getBurgerIngredient() as $bi) {
		    	$em->persist($bi);		    	
   		    	$em->flush();
	    	}
    	}
    	
        return $this->render('FiveMinToBurgerBundle:Default:addBurger.html.twig', array(
        	'form' => $form->createView(),
        ));
	}
}
