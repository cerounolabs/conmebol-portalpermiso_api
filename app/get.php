<?php
    $app->get('/v1/000/permiso', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE                  AS          tipo_permiso_codigo,
        a.NAME                  AS          tipo_permiso_codigo_nombre,
        a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
        a.U_NOMBRE              AS          tipo_permiso_nombre,
        a.U_CODINA              AS          tipo_permiso_coordina,
        a.U_CALIFICA            AS          tipo_permiso_califica,
        a.U_PERIODO             AS          tipo_permiso_periodo,
        a.U_CANPER              AS          tipo_permiso_cantidad
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                    'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                    'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                    'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                    'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                    'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                    'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                    'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_permiso_codigo'                       => '',
                    'tipo_permiso_codigo_nombre'                => '',
                    'tipo_permiso_codigo_referencia'            => '',
                    'tipo_permiso_nombre'                       => '',
                    'tipo_permiso_coordina'                     => '',
                    'tipo_permiso_califica'                     => '',
                    'tipo_permiso_periodo'                      => '',
                    'tipo_permiso_cantidad'                     => ''
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
            a.CODE                  AS          tipo_permiso_codigo,
            a.NAME                  AS          tipo_permiso_codigo_nombre,
            a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso_nombre,
            a.U_CODINA              AS          tipo_permiso_coordina,
            a.U_CALIFICA            AS          tipo_permiso_califica,
            a.U_PERIODO             AS          tipo_permiso_periodo,
            a.U_CANPER              AS          tipo_permiso_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                        'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                        'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                        'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                        'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                        'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                        'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_permiso_codigo'                       => '',
                        'tipo_permiso_codigo_nombre'                => '',
                        'tipo_permiso_codigo_referencia'            => '',
                        'tipo_permiso_nombre'                       => '',
                        'tipo_permiso_coordina'                     => '',
                        'tipo_permiso_califica'                     => '',
                        'tipo_permiso_periodo'                      => '',
                        'tipo_permiso_cantidad'                     => ''
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
            a.CODE                  AS          tipo_permiso_codigo,
            a.NAME                  AS          tipo_permiso_codigo_nombre,
            a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso_nombre,
            a.U_CODINA              AS          tipo_permiso_coordina,
            a.U_CALIFICA            AS          tipo_permiso_califica,
            a.U_PERIODO             AS          tipo_permiso_periodo,
            a.U_CANPER              AS          tipo_permiso_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                        'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                        'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                        'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                        'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                        'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                        'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_permiso_codigo'                       => '',
                        'tipo_permiso_codigo_nombre'                => '',
                        'tipo_permiso_codigo_referencia'            => '',
                        'tipo_permiso_nombre'                       => '',
                        'tipo_permiso_coordina'                     => '',
                        'tipo_permiso_califica'                     => '',
                        'tipo_permiso_periodo'                      => '',
                        'tipo_permiso_cantidad'                     => ''
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
            a.CODE                  AS          tipo_permiso_codigo,
            a.NAME                  AS          tipo_permiso_codigo_nombre,
            a.U_CODIGO              AS          tipo_permiso_codigo_referencia,
            a.U_NOMBRE              AS          tipo_permiso_nombre,
            a.U_CODINA              AS          tipo_permiso_coordina,
            a.U_CALIFICA            AS          tipo_permiso_califica,
            a.U_PERIODO             AS          tipo_permiso_periodo,
            a.U_CANPER              AS          tipo_permiso_cantidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a

            WHERE a.U_CODINA = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL['tipo_permiso_codigo'],
                        'tipo_permiso_codigo_nombre'                => $rowMSSQL['tipo_permiso_codigo_nombre'],
                        'tipo_permiso_codigo_referencia'            => trim(strtoupper($rowMSSQL['tipo_permiso_codigo_referencia'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL['tipo_permiso_nombre'])),
                        'tipo_permiso_coordina'                     => trim(strtoupper($rowMSSQL['tipo_permiso_coordina'])),
                        'tipo_permiso_califica'                     => trim(strtoupper($rowMSSQL['tipo_permiso_califica'])),
                        'tipo_permiso_periodo'                      => trim(strtoupper($rowMSSQL['tipo_permiso_periodo'])),
                        'tipo_permiso_cantidad'                     => $rowMSSQL['tipo_permiso_cantidad']
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_permiso_codigo'                       => '',
                        'tipo_permiso_codigo_nombre'                => '',
                        'tipo_permiso_codigo_referencia'            => '',
                        'tipo_permiso_nombre'                       => '',
                        'tipo_permiso_coordina'                     => '',
                        'tipo_permiso_califica'                     => '',
                        'tipo_permiso_periodo'                      => '',
                        'tipo_permiso_cantidad'                     => ''
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

    $app->get('/v1/000/licencia', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CODE                  AS          tipo_licencia_codigo,
        a.NAME                  AS          tipo_licencia_codigo_nombre,
        a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
        a.U_NOMBRE              AS          tipo_licencia_nombre,
        a.U_TIPO                AS          tipo_licencia_tipo,
        a.U_CODINA              AS          tipo_licencia_coordina
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                    'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                    'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                    'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                    'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                    'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_licencia_codigo'                      => '',
                    'tipo_licencia_codigo_nombre'               => '',
                    'tipo_licencia_codigo_referencia'           => '',
                    'tipo_licencia_nombre'                      => '',
                    'tipo_licencia_tipo'                        => '',
                    'tipo_licencia_coordina'                    => ''
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

    $app->get('/v1/000/licencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_licencia_codigo,
            a.NAME                  AS          tipo_licencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
            a.U_NOMBRE              AS          tipo_licencia_nombre,
            a.U_TIPO                AS          tipo_licencia_tipo,
            a.U_CODINA              AS          tipo_licencia_coordina
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                        'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                        'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                        'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                        'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                        'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_licencia_codigo'                      => '',
                        'tipo_licencia_codigo_nombre'               => '',
                        'tipo_licencia_codigo_referencia'           => '',
                        'tipo_licencia_nombre'                      => '',
                        'tipo_licencia_tipo'                        => '',
                        'tipo_licencia_coordina'                    => ''
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

    $app->get('/v1/000/licencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_licencia_codigo,
            a.NAME                  AS          tipo_licencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
            a.U_NOMBRE              AS          tipo_licencia_nombre,
            a.U_TIPO                AS          tipo_licencia_tipo,
            a.U_CODINA              AS          tipo_licencia_coordina
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                        'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                        'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                        'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                        'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                        'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_licencia_codigo'                      => '',
                        'tipo_licencia_codigo_nombre'               => '',
                        'tipo_licencia_codigo_referencia'           => '',
                        'tipo_licencia_nombre'                      => '',
                        'tipo_licencia_tipo'                        => '',
                        'tipo_licencia_coordina'                    => ''
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

    $app->get('/v1/000/licencia/coordina/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_licencia_codigo,
            a.NAME                  AS          tipo_licencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_licencia_codigo_referencia,
            a.U_NOMBRE              AS          tipo_licencia_nombre,
            a.U_TIPO                AS          tipo_licencia_tipo,
            a.U_CODINA              AS          tipo_licencia_coordina
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a

            WHERE a.U_CODINA = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_licencia_codigo'                      => $rowMSSQL['tipo_licencia_codigo'],
                        'tipo_licencia_codigo_nombre'               => $rowMSSQL['tipo_licencia_codigo_nombre'],
                        'tipo_licencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_licencia_codigo_referencia'])),
                        'tipo_licencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_licencia_nombre'])),
                        'tipo_licencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_licencia_tipo'])),
                        'tipo_licencia_coordina'                    => trim(strtoupper($rowMSSQL['tipo_licencia_coordina']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_licencia_codigo'                      => '',
                        'tipo_licencia_codigo_nombre'               => '',
                        'tipo_licencia_codigo_referencia'           => '',
                        'tipo_licencia_nombre'                      => '',
                        'tipo_licencia_tipo'                        => '',
                        'tipo_licencia_coordina'                    => ''
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

    $app->get('/v1/000/inasistencia', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
        a.CODE                  AS          tipo_inasistencia_codigo,
        a.NAME                  AS          tipo_inasistencia_codigo_nombre,
        a.U_CODIGO              AS          tipo_inasistencia_codigo_referencia,
        a.U_DESAMP              AS          tipo_inasistencia_nombre,
        a.U_TIPO                AS          tipo_inasistencia_tipo,
        a.U_UNIDAD              AS          tipo_inasistencia_unidad,
        a.U_IDENT               AS          tipo_inasistencia_identidad
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_inasistencia_codigo'                      => $rowMSSQL['tipo_inasistencia_codigo'],
                    'tipo_inasistencia_codigo_nombre'               => $rowMSSQL['tipo_inasistencia_codigo_nombre'],
                    'tipo_inasistencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_inasistencia_codigo_referencia'])),
                    'tipo_inasistencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_nombre'])),
                    'tipo_inasistencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_inasistencia_tipo'])),
                    'tipo_inasistencia_unidad'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_unidad'])),
                    'tipo_inasistencia_identidad'                   => trim(strtoupper($rowMSSQL['tipo_inasistencia_identidad']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_inasistencia_codigo'                      => '',
                    'tipo_inasistencia_codigo_nombre'               => '',
                    'tipo_inasistencia_codigo_referencia'           => '',
                    'tipo_inasistencia_nombre'                      => '',
                    'tipo_inasistencia_tipo'                        => '',
                    'tipo_inasistencia_unidad'                      => '',
                    'tipo_inasistencia_identidad'                   => ''
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

    $app->get('/v1/000/inasistencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_inasistencia_codigo,
            a.NAME                  AS          tipo_inasistencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_inasistencia_codigo_referencia,
            a.U_DESAMP              AS          tipo_inasistencia_nombre,
            a.U_TIPO                AS          tipo_inasistencia_tipo,
            a.U_UNIDAD              AS          tipo_inasistencia_unidad,
            a.U_IDENT               AS          tipo_inasistencia_identidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_inasistencia_codigo'                      => $rowMSSQL['tipo_inasistencia_codigo'],
                        'tipo_inasistencia_codigo_nombre'               => $rowMSSQL['tipo_inasistencia_codigo_nombre'],
                        'tipo_inasistencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_inasistencia_codigo_referencia'])),
                        'tipo_inasistencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_nombre'])),
                        'tipo_inasistencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_inasistencia_tipo'])),
                        'tipo_inasistencia_unidad'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_unidad'])),
                        'tipo_inasistencia_identidad'                   => trim(strtoupper($rowMSSQL['tipo_inasistencia_identidad']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_inasistencia_codigo'                      => '',
                        'tipo_inasistencia_codigo_nombre'               => '',
                        'tipo_inasistencia_codigo_referencia'           => '',
                        'tipo_inasistencia_nombre'                      => '',
                        'tipo_inasistencia_tipo'                        => '',
                        'tipo_inasistencia_unidad'                      => '',
                        'tipo_inasistencia_identidad'                   => ''
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

    $app->get('/v1/000/inasistencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE                  AS          tipo_inasistencia_codigo,
            a.NAME                  AS          tipo_inasistencia_codigo_nombre,
            a.U_CODIGO              AS          tipo_inasistencia_codigo_referencia,
            a.U_DESAMP              AS          tipo_inasistencia_nombre,
            a.U_TIPO                AS          tipo_inasistencia_tipo,
            a.U_UNIDAD              AS          tipo_inasistencia_unidad,
            a.U_IDENT               AS          tipo_inasistencia_identidad
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_inasistencia_codigo'                      => $rowMSSQL['tipo_inasistencia_codigo'],
                        'tipo_inasistencia_codigo_nombre'               => $rowMSSQL['tipo_inasistencia_codigo_nombre'],
                        'tipo_inasistencia_codigo_referencia'           => trim(strtoupper($rowMSSQL['tipo_inasistencia_codigo_referencia'])),
                        'tipo_inasistencia_nombre'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_nombre'])),
                        'tipo_inasistencia_tipo'                        => trim(strtoupper($rowMSSQL['tipo_inasistencia_tipo'])),
                        'tipo_inasistencia_unidad'                      => trim(strtoupper($rowMSSQL['tipo_inasistencia_unidad'])),
                        'tipo_inasistencia_identidad'                   => trim(strtoupper($rowMSSQL['tipo_inasistencia_identidad']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_inasistencia_codigo'                      => '',
                        'tipo_inasistencia_codigo_nombre'               => '',
                        'tipo_inasistencia_codigo_referencia'           => '',
                        'tipo_inasistencia_nombre'                      => '',
                        'tipo_inasistencia_tipo'                        => '',
                        'tipo_inasistencia_unidad'                      => '',
                        'tipo_inasistencia_identidad'                   => ''
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

    $app->get('/v1/000/cargo', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE              AS          tipo_cargo_codigo,
        a.NAME              AS          tipo_cargo_codigo_nombre,
        a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
        a.U_NOMBRE          AS          tipo_cargo_nombre,
        a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
        a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
        a.U_PUELIB          AS          tipo_cargo_libre,
        a.U_GRADO           AS          tipo_cargo_grado,

        b.CODE              AS          tipo_superior_cargo_codigo,
        b.NAME              AS          tipo_superior_cargo_codigo_nombre,
        b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
        b.U_NOMBRE          AS          tipo_superior_cargo_nombre
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
        LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                    'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                    'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                    'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                    'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                    'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                    'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                    'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                    'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                    'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                    'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                    'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_cargo_codigo'                             => '',
                    'tipo_cargo_codigo_nombre'                      => '',
                    'tipo_cargo_codigo_referencia'                  => '',
                    'tipo_cargo_nombre'                             => '',
                    'tipo_cargo_puesto_cantidad'                    => '',
                    'tipo_cargo_puesto_ocupado'                     => '',
                    'tipo_cargo_libre'                              => '',
                    'tipo_cargo_grado'                              => '',
                    'tipo_superior_cargo_codigo'                    => '',
                    'tipo_superior_cargo_codigo_nombre'             => '',
                    'tipo_superior_cargo_codigo_referencia'         => '',
                    'tipo_superior_cargo_nombre'                    => ''
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

    $app->get('/v1/000/cargo/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
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

    $app->get('/v1/000/cargo/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
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

    $app->get('/v1/000/cargo/superior/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE b.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                        
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
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

    $app->get('/v1/000/cargo/superior/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_cargo_codigo,
            a.NAME              AS          tipo_cargo_codigo_nombre,
            a.U_CODIGO          AS          tipo_cargo_codigo_referencia,
            a.U_NOMBRE          AS          tipo_cargo_nombre,
            a.U_PUESTOS         AS          tipo_cargo_puesto_cantidad,
            a.U_PUEOCU          AS          tipo_cargo_puesto_ocupado,
            a.U_PUELIB          AS          tipo_cargo_libre,
            a.U_GRADO           AS          tipo_cargo_grado,

            b.CODE              AS          tipo_superior_cargo_codigo,
            b.NAME              AS          tipo_superior_cargo_codigo_nombre,
            b.U_CODIGO          AS          tipo_superior_cargo_codigo_referencia,
            b.U_NOMBRE          AS          tipo_superior_cargo_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TICA] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TICA] b ON a.U_CARSUP = b.U_CODIGO

            WHERE b.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_cargo_codigo'                             => $rowMSSQL['tipo_cargo_codigo'],
                        'tipo_cargo_codigo_nombre'                      => $rowMSSQL['tipo_cargo_codigo_nombre'],
                        'tipo_cargo_codigo_referencia'                  => $rowMSSQL['tipo_cargo_codigo_referencia'],
                        'tipo_cargo_nombre'                             => trim(strtoupper($rowMSSQL['tipo_cargo_nombre'])),
                        'tipo_cargo_puesto_cantidad'                    => $rowMSSQL['tipo_cargo_puesto_cantidad'],
                        'tipo_cargo_puesto_ocupado'                     => $rowMSSQL['tipo_cargo_puesto_ocupado'],
                        'tipo_cargo_libre'                              => $rowMSSQL['tipo_cargo_libre'],
                        'tipo_cargo_grado'                              => $rowMSSQL['tipo_cargo_grado'],
                        'tipo_superior_cargo_codigo'                    => $rowMSSQL['tipo_superior_cargo_codigo'],
                        'tipo_superior_cargo_codigo_nombre'             => $rowMSSQL['tipo_superior_cargo_codigo_nombre'],
                        'tipo_superior_cargo_codigo_referencia'         => $rowMSSQL['tipo_superior_cargo_codigo_referencia'],
                        'tipo_superior_cargo_nombre'                    => trim(strtoupper($rowMSSQL['tipo_superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_cargo_codigo'                             => '',
                        'tipo_cargo_codigo_nombre'                      => '',
                        'tipo_cargo_codigo_referencia'                  => '',
                        'tipo_cargo_nombre'                             => '',
                        'tipo_cargo_puesto_cantidad'                    => '',
                        'tipo_cargo_puesto_ocupado'                     => '',
                        'tipo_cargo_libre'                              => '',
                        'tipo_cargo_grado'                              => '',
                        'tipo_superior_cargo_codigo'                    => '',
                        'tipo_superior_cargo_codigo_nombre'             => '',
                        'tipo_superior_cargo_codigo_referencia'         => '',
                        'tipo_superior_cargo_nombre'                    => ''
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

    $app->get('/v1/000/gerencia', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE              AS          tipo_gerencia_codigo,
        a.NAME              AS          tipo_gerencia_codigo_nombre,
        a.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
        a.U_NOMBRE          AS          tipo_gerencia_nombre
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIGE] a

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_gerencia_codigo'                             => $rowMSSQL['tipo_gerencia_codigo'],
                    'tipo_gerencia_codigo_nombre'                      => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                    'tipo_gerencia_codigo_referencia'                  => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                    'tipo_gerencia_nombre'                             => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_gerencia_codigo'                             => '',
                    'tipo_gerencia_codigo_nombre'                      => '',
                    'tipo_gerencia_codigo_referencia'                  => '',
                    'tipo_gerencia_nombre'                             => ''
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

    $app->get('/v1/000/gerencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_gerencia_codigo,
            a.NAME              AS          tipo_gerencia_codigo_nombre,
            a.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            a.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIGE] a

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_gerencia_codigo'                             => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                      => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'                  => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                             => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_gerencia_codigo'                             => '',
                        'tipo_gerencia_codigo_nombre'                      => '',
                        'tipo_gerencia_codigo_referencia'                  => '',
                        'tipo_gerencia_nombre'                             => ''
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

    $app->get('/v1/000/gerencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_gerencia_codigo,
            a.NAME              AS          tipo_gerencia_codigo_nombre,
            a.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            a.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIGE] a

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_gerencia_codigo'                             => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                      => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'                  => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                             => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_gerencia_codigo'                             => '',
                        'tipo_gerencia_codigo_nombre'                      => '',
                        'tipo_gerencia_codigo_referencia'                  => '',
                        'tipo_gerencia_nombre'                             => ''
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

    $app->get('/v1/000/departamento', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.CODE              AS          tipo_departamento_codigo,
        a.NAME              AS          tipo_departamento_codigo_nombre,
        a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
        a.U_NOMBRE          AS          tipo_departamento_nombre,

        b.CODE              AS          tipo_gerencia_codigo,
        b.NAME              AS          tipo_gerencia_codigo_nombre,
        b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
        b.U_NOMBRE          AS          tipo_gerencia_nombre
        
        FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
        LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

        ORDER BY a.U_CODIGO";

        try {
            $connMSSQL  = getConnectionMSSQL();
            $stmtMSSQL  = $connMSSQL->prepare($sql00);
            $stmtMSSQL->execute(); 

            while ($rowMSSQL = $stmtMSSQL->fetch()) {
                $detalle    = array(
                    'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                    'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                    'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                    'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                    'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                    'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                    'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                    'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_departamento_codigo'                      => '',
                    'tipo_departamento_codigo_nombre'               => '',
                    'tipo_departamento_codigo_referencia'           => '',
                    'tipo_departamento_nombre'                      => '',
                    'tipo_gerencia_codigo'                          => '',
                    'tipo_gerencia_codigo_nombre'                   => '',
                    'tipo_gerencia_codigo_referencia'               => '',
                    'tipo_gerencia_nombre'                          => ''
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

    $app->get('/v1/000/departamento/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE a.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
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

    $app->get('/v1/000/departamento/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE a.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
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

    $app->get('/v1/000/departamento/gerencia/codigo/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE b.CODE = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
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

    $app->get('/v1/000/departamento/gerencia/referencia/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
            a.CODE              AS          tipo_departamento_codigo,
            a.NAME              AS          tipo_departamento_codigo_nombre,
            a.U_CODIGO          AS          tipo_departamento_codigo_referencia,
            a.U_NOMBRE          AS          tipo_departamento_nombre,

            b.CODE              AS          tipo_gerencia_codigo,
            b.NAME              AS          tipo_gerencia_codigo_nombre,
            b.U_CODIGO          AS          tipo_gerencia_codigo_referencia,
            b.U_NOMBRE          AS          tipo_gerencia_nombre
            
            FROM [CSF_PRUEBA].[dbo].[@A1A_TIDE] a
            LEFT OUTER JOIN [CSF_PRUEBA].[dbo].[@A1A_TIGE] b ON a.U_CODGER = b.U_CODIGO

            WHERE b.U_CODIGO = ?

            ORDER BY a.U_CODIGO";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL  = $connMSSQL->prepare($sql00);
                $stmtMSSQL->execute([$val01]); 

                while ($rowMSSQL = $stmtMSSQL->fetch()) {
                    $detalle    = array(
                        'tipo_departamento_codigo'                      => $rowMSSQL['tipo_departamento_codigo'],
                        'tipo_departamento_codigo_nombre'               => $rowMSSQL['tipo_departamento_codigo_nombre'],
                        'tipo_departamento_codigo_referencia'           => $rowMSSQL['tipo_departamento_codigo_referencia'],
                        'tipo_departamento_nombre'                      => trim(strtoupper($rowMSSQL['tipo_departamento_nombre'])),
                        'tipo_gerencia_codigo'                          => $rowMSSQL['tipo_gerencia_codigo'],
                        'tipo_gerencia_codigo_nombre'                   => $rowMSSQL['tipo_gerencia_codigo_nombre'],
                        'tipo_gerencia_codigo_referencia'               => $rowMSSQL['tipo_gerencia_codigo_referencia'],
                        'tipo_gerencia_nombre'                          => trim(strtoupper($rowMSSQL['tipo_gerencia_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle = array(
                        'tipo_departamento_codigo'                      => '',
                        'tipo_departamento_codigo_nombre'               => '',
                        'tipo_departamento_codigo_referencia'           => '',
                        'tipo_departamento_nombre'                      => '',
                        'tipo_gerencia_codigo'                          => '',
                        'tipo_gerencia_codigo_nombre'                   => '',
                        'tipo_gerencia_codigo_referencia'               => '',
                        'tipo_gerencia_nombre'                          => ''
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

    $app->get('/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $sql00  = "SELECT
        a.DOMPARCOD         AS          tipo_permiso_codigo,
        a.DOMPAREST         AS          tipo_estado_codigo,
        a.DOMPARTST         AS          tipo_solicitud_codigo,
        a.DOMPARPC1         AS          tipo_permiso_codigo1,
        a.DOMPARPC2         AS          tipo_permiso_codigo2,
        a.DOMPARPC3         AS          tipo_permiso_codigo3,
        a.DOMPARORD         AS          tipo_orden_numero,
        a.DOMPARDIC         AS          tipo_dia_cantidad,
        a.DOMPARDIO         AS          tipo_dia_corrido,
        a.DOMPAROBS         AS          tipo_observacion,
        a.DOMPARAUS         AS          auditoria_usuario,
        a.DOMPARAFH         AS          auditoria_fecha_hora,
        a.DOMPARAIP         AS          auditoria_ip
        
        FROM [CSF_PERMISOS].[adm].[DOMPAR] a

        ORDER BY a.DOMPARTST, a.DOMPARORD";

        try {
            $connMSSQL  = getConnectionMSSQL();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute(); 

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                $sql01  = '';

                switch ($rowMSSQL00['tipo_estado_codigo']) {
                    case 'A':
                        $tipo_estado_nombre = 'ACTIVO';
                        break;
                    
                    case 'I':
                        $tipo_estado_nombre = 'INACTIVO';
                        break;
                }

                switch ($rowMSSQL00['tipo_solicitud_codigo']) {
                    case 'L':
                        $tipo_solicitud_nombre  = 'LICENCIA';
                        $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM CFS_PRUEBA.dbo.[@A1A_TILC] WHERE Code = ? AND Name = ? AND U_CODIGO = ?";
                        break;
                    
                    case 'P':
                        $tipo_solicitud_nombre  = 'PERMISO';
                        $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM CFS_PRUEBA.dbo.[@A1A_TIPE] WHERE Code = ? AND Name = ? AND U_CODIGO = ?";
                        break;
    
                    case 'I':
                        $tipo_solicitud_nombre  = 'INASISTENCIA';
                        $sql01                  = "SELECT U_DESAMP AS tipo_permiso_nombre FROM CFS_PRUEBA.dbo.[@A1A_TIIN] WHERE Code = ? AND Name = ? AND U_CODIGO = ?";
                        break;
                }

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([$rowMSSQL00['tipo_permiso_codigo1'], $rowMSSQL00['tipo_permiso_codigo2'], $rowMSSQL00['tipo_permiso_codigo3']]);

                $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);
                $detalle    = array(
                    'tipo_permiso_codigo'                       => $rowMSSQL00['tipo_permiso_codigo'],
                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre'                        => trim(strtoupper($tipo_estado_nombre)),
                    'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                    'tipo_solicitud_nombre'                     => trim(strtoupper($tipo_solicitud_nombre)),
                    'tipo_permiso_codigo1'                      => $rowMSSQL00['tipo_permiso_codigo1'],
                    'tipo_permiso_codigo2'                      => $rowMSSQL00['tipo_permiso_codigo2'],
                    'tipo_permiso_codigo3'                      => trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3'])),
                    'tipo_permiso_nombre'                       => trim(strtoupper($rowMSSQL01['tipo_permiso_nombre'])),
                    'tipo_orden_numero'                         => $rowMSSQL00['tipo_orden_numero'],
                    'tipo_dia_cantidad'                         => $rowMSSQL00['tipo_dia_cantidad'],
                    'tipo_dia_corrido'                          => trim(strtoupper($rowMSSQL00['tipo_dia_corrido'])),
                    'tipo_observacion'                          => trim(strtoupper($rowMSSQL00['tipo_observacion'])),
                    'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle = array(
                    'tipo_permiso_codigo'                       => '',
                    'tipo_estado_codigo'                        => '',
                    'tipo_estado_nombre'                        => '',
                    'tipo_solicitud_codigo'                     => '',
                    'tipo_solicitud_nombre'                     => '',
                    'tipo_permiso_codigo1'                      => '',
                    'tipo_permiso_codigo2'                      => '',
                    'tipo_permiso_codigo3'                      => '',
                    'tipo_permiso_nombre'                       => '',
                    'tipo_orden_numero'                         => '',
                    'tipo_dia_cantidad'                         => '',
                    'tipo_dia_corrido'                          => '',
                    'tipo_observacion'                          => '',
                    'auditoria_usuario'                         => '',
                    'auditoria_fecha_hora'                      => '',
                    'auditoria_ip'                              => ''
                );

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }

            $stmtMSSQL00->closeCursor();
            $stmtMSSQL00 = null;
        } catch (PDOException $e) {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error SELECT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });