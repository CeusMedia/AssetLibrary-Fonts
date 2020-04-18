<?php
$darkMode	= !TRUE;

/*  --  NO NEED TO CHANGE BELOW  --  */
class FontAwesomeIndex{

	public function __construct( $darkMode = FALSE ){
		$list	= $this->read();
		$this->render( $list, $darkMode );
	}

	protected function read(){
		$list		= array();
		$pattern	= '/^\.fa-(.+):before {$/';
		$content	= file_get_contents( "font-awesome.css" );
		$lines		= explode( "\n", $content );
		foreach( $lines as $line ){
			if( preg_match( $pattern, $line ) ){
				$list[]	= preg_replace( $pattern, "\\1", $line );
			}
		}
		return $list;
	}

	protected function render( $iconClasses, $darkMode = FALSE ){
		$list	= array();
		foreach( $iconClasses as $item ){
			$icon	= '<i class="fa fa-2x fa-'.$item.( $darkMode ? ' fa-inverse' :'' ).'" title="'.$item.'"></i>';
			$list[]	= '<li class="icon-container" id="icon-'.$item.'">'.$icon.'</li>';
		}
		$list	= '<ul id="icon-matrix" class="unstyled">'.join( $list ).'</ul>';
		$style	= '
body.dark {
	background-color: rgba(0,0,0,1);
	color: rgba(255,255,255,0.8);
	}
#icon-matrix .fa {
	transition: all 0.2s;
	opacity: 0.8;
	color: rgba(0,0,0,0.8);
	}
#icon-matrix .fa-inverse {
	color: rgba(255,255,255,0.8);
	}
#icon-matrix .fa:hover {
	opacity: 1;
	color: black;
	}
#icon-matrix .fa-inverse:hover {
	color: white;
	}
#icon-matrix .icon-container {
	float: left;
	width: 48px;
	height: 48px;
	vertical-align: middle;
	text-align: center;
	margin: 3px;
	}
#icon-matrix .fa-2x {
	line-height: 2em;
	}
#icon-matrix .fa-4x {
	line-height: 1em;
	}
';
		$script	= '
$(document).ready(function(){
	$(".icon-container").bind("mouseenter", function(){
		$(this).children("i").addClass("fa-4x");
	}).bind("mouseleave", function(){
		$(this).children("i").removeClass("fa-4x");
	}).bind("click", function(){
		var query = $(this).children("i").prop("title");
		$(this).trigger("mouseleave");
		$("#search").val(query).trigger("keyup");
	});
	$("#search").bind("keyup", function(){
		var query = $(this).val();
		$(".icon-container i").each(function(){
			var matching = $(this).prop("title").match(query);
			matching ? $(this).parent().show() : $(this).parent().hide();
		});
	}).focus();
});';

		$cdn	= 'https://cdn.ceusmedia.de/';
		print '
<html>
	<head>
		<link rel="stylesheet" href="'.$cdn.'css/bootstrap.min.css"></link>
		<link rel="stylesheet" href="font-awesome.min.css"></link>
		<script src="'.$cdn.'js/jquery/1.10.2.min.js"></script>
		<script src="'.$cdn.'js/bootstrap.min.js"></script>
		<style>'.$style.'</style>
		<script>'.$script.'</script>
	</head>
	<body class="'.( $darkMode ? 'dark' : 'bright' ).'">
		<div class="container">
			<h2>Font Awesome <span class="muted">Index</span></h2>
			<div class="row-fluid">
				<div class="span12">
					<input type="search" id="search" placeholder="search"></input>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					'.$list.'
				</div>
			</div>
		</div>
	</body>
</html>';
	}

}
new FontAwesomeIndex( $darkMode );
