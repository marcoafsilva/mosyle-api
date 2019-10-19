<?php

namespace Api\Response;

abstract class HttpStatus
{
    const SUCCESS = [
        'code'  => 200,
        'msg'   => 'Sucesso'
    ];

    const INVALID_REQUISITION = [
        'code'  => 400,
        'msg'   => 'Requisição inválida'
    ];

    const NOT_FOUND = [
        'code'  => 404,
        'msg'   => 'Não encontrado'
    ];

    const METHOD_NOT_ALLOWED = [
        'code'  => 405,
        'msg'   => 'Método não permitido'
    ];

    const INTERN_ERROR = [
        'code'  => 500,
        'msg'   => 'Erro interno do servidor'
    ];
}