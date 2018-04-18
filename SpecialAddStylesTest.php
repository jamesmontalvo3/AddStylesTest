<?php

class SpecialAddStylesTest extends SpecialPage {

	public $mMode;

	public function __construct() {
		parent::__construct(
			"AddStylesTest", //
			"",  // rights required to view
			true // show in Special:SpecialPages
		);
	}

	public function execute( $parser = null ) {

		// $this->setHeaders();

		$position = $this->getRequest()->getVal( 'position', 'top' );
		$mode = $this->getRequest()->getVal( 'mode', 'both' );

		$out = $this->getOutput();
		$out->addHTML( "<p>set query string 'position' to 'top', 'bottom', or 'both' to use the 'top' or 'bottom' resource.</p>" );
		$out->addHTML( "<p>set query string 'mode' to 'styles', 'scripts', or 'both'</p>" );
		$out->addHTML( "<p>Scripts will write to the JS console, e.g. 'top script included'.</p>" );
		$out->addHTML( "<p>CSS will style the div below.</p>" );

		$contents = "mode = $mode, position = $position. ";

		if ( $position === 'top' || $position === 'both' ) {
			$this->addModule( 'top', $mode );
			$contents .= "Attempting to load top resource. ";
		}

		if ( $position === 'bottom' || $position === 'both' ) {
			$this->addModule( 'bottom', $mode );
			$contents .= "Attempting to load bottom resource. ";
		}


		$out->addHTML( "<div class='add-styles-test-top add-styles-test-bottom'>$contents</div>" );

	}

	protected function addModule ( $position, $mode ) {
		if ( ! in_array( $position, ['top','bottom'] ) ) {
			$this->getOutput()->addHTML( '<p>bad "position" input</p>' );
			die();
		}

		if ( $mode === 'both' ) {
			$this->getOutput()->addModules( "ext.addstylestest.$position" );
		}
		else if ( $mode === 'scripts' ) {
			$this->getOutput()->addModuleScripts( "ext.addstylestest.$position" );
		}
		else if ( $mode === 'styles' ) {
			$this->getOutput()->addModuleStyles( "ext.addstylestest.$position" );
		}
		else {
			$this->getOutput()->addHTML( '<p>bad "mode" input</p>' );
			die();
		}
	}
}

