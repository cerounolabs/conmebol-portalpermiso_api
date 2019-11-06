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