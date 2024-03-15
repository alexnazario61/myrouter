<?php
	// Class Map
	abstract class ClassMap
	{
		// Property to store the class map
		private $_classMap;
		
		// Constructor to initialize the class map
		public function __construct($map)
		{
			$this->_classMap = $map;
		}
		
		// Function to get the class map
		public function getClassMap()
		{
			return $this->_classMap;
	
