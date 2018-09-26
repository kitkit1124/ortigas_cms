<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// material template
$template['material']['template'] = 'material/template';
$template['material']['regions'] = array('head', 'styles', 'header', 'content', 'footer', 'scripts');
$template['material']['parser'] = 'parser';
$template['material']['parser_method'] = 'parse';
$template['material']['parse_template'] = FALSE;

// blank
$template['blank']['template'] = 'material/blank';
$template['blank']['regions'] = array('styles', 'header', 'content', 'footer', 'scripts');
$template['blank']['parser'] = 'parser';
$template['blank']['parser_method'] = 'parse';
$template['blank']['parse_template'] = FALSE;

// modal
$template['modal']['template'] = 'material/modal';
$template['modal']['regions'] = array('styles', 'content', 'scripts');
$template['modal']['parser'] = 'parser';
$template['modal']['parser_method'] = 'parse';
$template['modal']['parse_template'] = FALSE;

// confirm
$template['confirm']['template'] = 'material/confirm';
$template['confirm']['regions'] = array('content');
$template['confirm']['parser'] = 'parser';
$template['confirm']['parser_method'] = 'parse';
$template['confirm']['parse_template'] = FALSE;