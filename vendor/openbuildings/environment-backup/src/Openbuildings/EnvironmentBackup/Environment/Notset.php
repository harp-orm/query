<?php

namespace Openbuildings\EnvironmentBackup;

/**
 * This class is used to denote an 'not set' varible. If a parameter was not present at all before a ->set() call
 * we use this class to remember that, and later on '->restore()' the parameter is restored to its previous state e.g. 'not present'
 * 
 * @package Openbuildings\EnvironmentBackup
 * @author Ivan Kerin
 * @copyright  (c) 2011-2013 Despark Ltd.
 */
class Environment_Notset {

}