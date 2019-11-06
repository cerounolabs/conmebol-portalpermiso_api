<?php
    $app->get('/v1/000/permiso', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE                  AS          tipo_codigo,
        a.NAME                  AS          tipo_nombre,
        a.U_CODIGO              AS          tipo_codigo_referencia,
        a.U_NOMBRE              AS          tipo_permiso,
        a.U_CODINA              AS          tipo_coordina,
        a.U_CALIFICA            AS          tipo_califica,
        a.U_PERIODO             AS          tipo_periodo,
        a.U_CANPER              AS          tipo_cantidad
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                    'tipo_nombre'                       => $rowMSSQL['tipo_nombre'],
                    'tipo_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_codigo_referencia'])),
                    'tipo_permiso'                      => trim(strtoupper($rowMSSQL['tipo_permiso'])),
                    'tipo_coordina'                     => trim(strtoupper($rowMSSQL['tipo_coordina'])),
                    'tipo_califica'                     => trim(strtoupper($rowMSSQL['tipo_califica'])),
                    'tipo_periodo'                      => trim(strtoupper($rowMSSQL['tipo_periodo'])),
                    'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_codigo'                       => '',
                    'tipo_nombre'                       => '',
                    'tipo_codigo_referencia'            => '',
                    'tipo_permiso'                      => '',
                    'tipo_coordina'                     => '',
                    'tipo_califica'                     => '',
                    'tipo_periodo'                      => '',
                    'tipo_cantidad'                     => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL->closeCursor();
            $stmtMSSQL = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/permiso/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_codigo,
            a.NAME                  AS          tipo_nombre,
            a.U_CODIGO              AS          tipo_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso,
            a.U_CODINA              AS          tipo_coordina,
            a.U_CALIFICA            AS          tipo_califica,
            a.U_PERIODO             AS          tipo_periodo,
            a.U_CANPER              AS          tipo_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre'                       => $rowMSSQL['tipo_nombre'],
                        'tipo_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_codigo_referencia'])),
                        'tipo_permiso'                      => trim(strtoupper($rowMSSQL['tipo_permiso'])),
                        'tipo_coordina'                     => trim(strtoupper($rowMSSQL['tipo_coordina'])),
                        'tipo_califica'                     => trim(strtoupper($rowMSSQL['tipo_califica'])),
                        'tipo_periodo'                      => trim(strtoupper($rowMSSQL['tipo_periodo'])),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre'                       => '',
                        'tipo_codigo_referencia'            => '',
                        'tipo_permiso'                      => '',
                        'tipo_coordina'                     => '',
                        'tipo_califica'                     => '',
                        'tipo_periodo'                      => '',
                        'tipo_cantidad'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/permiso/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_codigo,
            a.NAME                  AS          tipo_nombre,
            a.U_CODIGO              AS          tipo_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso,
            a.U_CODINA              AS          tipo_coordina,
            a.U_CALIFICA            AS          tipo_califica,
            a.U_PERIODO             AS          tipo_periodo,
            a.U_CANPER              AS          tipo_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre'                       => $rowMSSQL['tipo_nombre'],
                        'tipo_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_codigo_referencia'])),
                        'tipo_permiso'                      => trim(strtoupper($rowMSSQL['tipo_permiso'])),
                        'tipo_coordina'                     => trim(strtoupper($rowMSSQL['tipo_coordina'])),
                        'tipo_califica'                     => trim(strtoupper($rowMSSQL['tipo_califica'])),
                        'tipo_periodo'                      => trim(strtoupper($rowMSSQL['tipo_periodo'])),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre'                       => '',
                        'tipo_codigo_referencia'            => '',
                        'tipo_permiso'                      => '',
                        'tipo_coordina'                     => '',
                        'tipo_califica'                     => '',
                        'tipo_periodo'                      => '',
                        'tipo_cantidad'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/000/permiso/coordina/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_codigo,
            a.NAME                  AS          tipo_nombre,
            a.U_CODIGO              AS          tipo_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso,
            a.U_CODINA              AS          tipo_coordina,
            a.U_CALIFICA            AS          tipo_califica,
            a.U_PERIODO             AS          tipo_periodo,
            a.U_CANPER              AS          tipo_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.U_CODINA = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_codigo'                       => $rowMSSQL['tipo_codigo'],
                        'tipo_nombre'                       => $rowMSSQL['tipo_nombre'],
                        'tipo_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_codigo_referencia'])),
                        'tipo_permiso'                      => trim(strtoupper($rowMSSQL['tipo_permiso'])),
                        'tipo_coordina'                     => trim(strtoupper($rowMSSQL['tipo_coordina'])),
                        'tipo_califica'                     => trim(strtoupper($rowMSSQL['tipo_califica'])),
                        'tipo_periodo'                      => trim(strtoupper($rowMSSQL['tipo_periodo'])),
                        'tipo_cantidad'                     => $rowMSSQL['tipo_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_codigo'                       => '',
                        'tipo_nombre'                       => '',
                        'tipo_codigo_referencia'            => '',
                        'tipo_permiso'                      => '',
                        'tipo_coordina'                     => '',
                        'tipo_califica'                     => '',
                        'tipo_periodo'                      => '',
                        'tipo_cantidad'                     => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL->closeCursor();
                $stmtMSSQL = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });