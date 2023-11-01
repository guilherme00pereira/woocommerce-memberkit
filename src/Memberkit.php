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

	public function getClassrooms()
	{
		try {
			$resp = wp_remote_get( self::API_URL . 'classrooms');
			
			if( is_wp_error( $resp ) ) {
				$error_message = $resp->get_error_message();
				Logger::getInstance()->add( "Chamada à API. Erro: " .$resp->get_error_code() . ": Não foi possível obter as turmas => Mensagem:" . $error_message );
			} else {
				$classrooms = json_decode( wp_remote_retrieve_body( $resp ) );
				Logger::getInstance()->add( "Total de turmas obtidas do MemberKit: " . PHP_EOL . count($classrooms) );
				return $classrooms;
			}
		} catch ( Exception $e ) {
			Logger::getInstance()->add( "Chamada à API. Erro: " .$resp->get_error_code() . ": Não foi possível obter as turmas => Mensagem:" . $error_message );
		}
	}

    public function addUser( $name, $mail, $ids ) {
		$params = [
            'body' => [
			'full_name'     => $name,
			'email'         => $mail,
			'status'        => 'active',
			'blocked'       => false,
			'classroom_ids' => $ids,
			'api_key'       => self::API_KEY
			],
			'headers' => [
				"Content-Type" => "application/json",

			],
		];

		try {
			$resp = wp_remote_post( self::API_URL . 'users', $params );
            if( is_wp_error( $resp ) ) {
                $error_message = $resp->get_error_message();
                Logger::getInstance()->add( "Chamada à API. Erro: " .$resp->get_error_code() . ": Não foi possível adicionar o usuário => Mensagem:" . $error_message );
            } else {
                $userData = json_decode( wp_remote_retrieve_body( $resp ) );
                Logger::getInstance()->add(  "Usuário  cadastrado no MemberKit: " . PHP_EOL . $userData );
            }
		} catch ( Exception $e ) {
			Logger::getInstance()->add( "Chamada à API. Erro: " .$e->getCode() . ": Não foi possível adicionar o usuário => Mensagem:" . $e->getMessage() );
		}
	}
    
}