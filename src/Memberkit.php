<?php

namespace G28\WoocommerceMemberkit;

use Exception;
use WC_Logger;

class Memberkit
{
    const API_URL = "https://memberkit.com.br/api/v1/";
    const API_KEY = "S4PKveRnL4yHTs4zr3U2rBpV";

    public function __construct()
	{
		
	}

	public function getClassroms()
	{
		try {
			$resp = wp_remote_get( self::API_URL . 'classrooms', [
				'body' => [
					'api_key' => self::API_KEY
				]
			]);
			
			if( is_wp_error( $resp ) ) {
				$error_message = $resp->get_error_message();
				Logger::getInstance()->add( "Chamada à API. Erro: " .$resp->get_error_code() . ": Não foi possível obter as turmas => Mensagem:" . $error_message );
				return null;
			} else {
				return json_decode( wp_remote_retrieve_body( $resp ) );
			}
		} catch ( Exception $e ) {
			Logger::getInstance()->add( "Chamada à API. Erro: " .$e->getCode() . ": Não foi possível obter as turmas => Mensagem:" . $error_message );
			return null;
		}
	}

    public function addUser( $name, $mail, $ids, $course_string ) {
		$params = [
            'body' => [
			'full_name'     => $name,
			'email'         => $mail,
			'status'        => 'active',
			'blocked'       => false,
			'classroom_ids' => $ids,
			'api_key'       => self::API_KEY
			],
		];

		try {
			$resp = wp_remote_post( self::API_URL . 'users', $params );
            if( is_wp_error( $resp ) ) {
                $error_message = $resp->get_error_message();
                Logger::getInstance()->add( "Chamada à API. Erro: " .$resp->get_error_code() . ": Não foi possível adicionar o usuário => Mensagem:" . $error_message );
            } else {
                $userData = json_decode( wp_remote_retrieve_body( $resp ) );;
                Logger::getInstance()->add(  "Usuário " . $userData->full_name .
                     " foi cadastrado no(s) curso(s): " . $course_string);
            }
		} catch ( Exception $e ) {
			Logger::getInstance()->add( "Chamada à API. Erro: " .$e->getCode() . ": Não foi possível adicionar o usuário => Mensagem:" . $e->getMessage() );
		}
	}
    
}