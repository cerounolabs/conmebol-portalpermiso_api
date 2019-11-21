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
                        $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                        break;
                    
                    case 'P':
                        $tipo_solicitud_nombre  = 'PERMISO';
                        $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                        break;
    
                    case 'I':
                        $tipo_solicitud_nombre  = 'INASISTENCIA';
                        $sql01                  = "SELECT U_DESAMP AS tipo_permiso_nombre FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                        break;
                }

                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3']))]);
                $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                $tipo_permiso_nombre = $rowMSSQL01['tipo_permiso_nombre'];

                $detalle    = array(
                    'tipo_permiso_codigo'                       => $rowMSSQL00['tipo_permiso_codigo'],
                    'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                    'tipo_estado_nombre'                        => trim(strtoupper($tipo_estado_nombre)),
                    'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                    'tipo_solicitud_nombre'                     => trim(strtoupper($tipo_solicitud_nombre)),
                    'tipo_permiso_codigo1'                      => $rowMSSQL00['tipo_permiso_codigo1'],
                    'tipo_permiso_codigo2'                      => $rowMSSQL00['tipo_permiso_codigo2'],
                    'tipo_permiso_codigo3'                      => trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3'])),
                    'tipo_permiso_nombre'                       => trim(strtoupper($tipo_permiso_nombre)),
                    'tipo_orden_numero'                         => $rowMSSQL00['tipo_orden_numero'],
                    'tipo_dia_cantidad'                         => $rowMSSQL00['tipo_dia_cantidad'],
                    'tipo_dia_corrido'                          => trim(strtoupper($rowMSSQL00['tipo_dia_corrido'])),
                    'tipo_observacion'                          => trim(strtoupper($rowMSSQL00['tipo_observacion'])),
                    'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                    'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                    'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip']))
                );

                $result[]   = $detalle;

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
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

    $app->get('/v1/100/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
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

            WHERE a.DOMPARCOD = ?

            ORDER BY a.DOMPARTST, a.DOMPARORD";

            try {
                $connMSSQL  = getConnectionMSSQL();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);
                
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
                            $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                            break;
                        
                        case 'P':
                            $tipo_solicitud_nombre  = 'PERMISO';
                            $sql01                  = "SELECT U_NOMBRE AS tipo_permiso_nombre FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                            break;
        
                        case 'I':
                            $tipo_solicitud_nombre  = 'INASISTENCIA';
                            $sql01                  = "SELECT U_DESAMP AS tipo_permiso_nombre FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                            break;
                    }

                    $stmtMSSQL01= $connMSSQL->prepare($sql01);
                    $stmtMSSQL01->execute([trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3']))]);
                    $rowMSSQL01 = $stmtMSSQL01->fetch(PDO::FETCH_ASSOC);

                    $tipo_permiso_nombre = $rowMSSQL01['tipo_permiso_nombre'];

                    $detalle    = array(
                        'tipo_permiso_codigo'                       => $rowMSSQL00['tipo_permiso_codigo'],
                        'tipo_estado_codigo'                        => $rowMSSQL00['tipo_estado_codigo'],
                        'tipo_estado_nombre'                        => trim(strtoupper($tipo_estado_nombre)),
                        'tipo_solicitud_codigo'                     => $rowMSSQL00['tipo_solicitud_codigo'],
                        'tipo_solicitud_nombre'                     => trim(strtoupper($tipo_solicitud_nombre)),
                        'tipo_permiso_codigo1'                      => $rowMSSQL00['tipo_permiso_codigo1'],
                        'tipo_permiso_codigo2'                      => $rowMSSQL00['tipo_permiso_codigo2'],
                        'tipo_permiso_codigo3'                      => trim(strtoupper($rowMSSQL00['tipo_permiso_codigo3'])),
                        'tipo_permiso_nombre'                       => trim(strtoupper($tipo_permiso_nombre)),
                        'tipo_orden_numero'                         => $rowMSSQL00['tipo_orden_numero'],
                        'tipo_dia_cantidad'                         => $rowMSSQL00['tipo_dia_cantidad'],
                        'tipo_dia_corrido'                          => trim(strtoupper($rowMSSQL00['tipo_dia_corrido'])),
                        'tipo_observacion'                          => trim(strtoupper($rowMSSQL00['tipo_observacion'])),
                        'auditoria_usuario'                         => trim(strtoupper($rowMSSQL00['auditoria_usuario'])),
                        'auditoria_fecha_hora'                      => $rowMSSQL00['auditoria_fecha_hora'],
                        'auditoria_ip'                              => trim(strtoupper($rowMSSQL00['auditoria_ip']))
                    );

                    $result[]   = $detalle;

                    $stmtMSSQL01->closeCursor();
                    $stmtMSSQL01 = null;
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
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';

        $sql00  = "SELECT
            a.CedulaEmpleado            AS          documento,
            a.ApellidoPaterno           AS          apellido_1,
            a.ApellidoMaterno           AS          apellido_2,
            a.PrimerNombre              AS          nombre_1,
            a.SegundoNombre             AS          nombre_2,
            a.NombreEmpleado            AS          nombre_completo,
            a.Sexo                      AS          tipo_sexo_codigo,
            a.EstadoCivil               AS          estado_civil_codigo,
            a.Email                     AS          email,
            a.FechaNacimiento           AS          fecha_nacimiento,
            a.CodigoCargo               AS          cargo_codigo,
            a.Cargo                     AS          cargo_nombre,
            a.CodigoGerencia            AS          gerencia_codigo,
            a.Gerencia                  AS          gerencia_nombre,
            a.CodigoDepto               AS          departamento_codigo,
            a.Departamento              AS          departamento_nombre,         
            a.CodCargoSuperior          AS          superior_cargo_codigo,
            a.NombreCargoSuperior       AS          superior_cargo_nombre

            FROM [CSF_PRUEBA].[dbo].[empleados_AxisONE] a";

        try {
            $connMSSQL  = getConnectionMSSQL();

            $stmtMSSQL00= $connMSSQL->prepare($sql00);
            $stmtMSSQL00->execute([$val01]);

            while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                switch ($rowMSSQL00['tipo_sexo_codigo']) {
                    case 'M':
                        $tipo_sexo_nombre = 'MASCULINO';
                        break;
                    
                    case 'F':
                        $tipo_sexo_nombre = 'FEMENINO';
                        break;
                }

                switch ($rowMSSQL00['estado_civil_codigo']) {
                    case 'S':
                        $estado_civil_nombre = 'SOLTERO/A';
                        break;
                    
                    case 'C':
                        $estado_civil_nombre = 'CASADO/A';
                        break;

                    case 'D':
                        $estado_civil_nombre = 'DIVORCIADO/A';
                        break;

                    case 'V':
                        $estado_civil_nombre = 'VIUDO/A';
                        break;
                }

                $detalle    = array(
                    'documento'                     => $rowMSSQL00['documento'],
                    'apellido_1'                    => trim(strtoupper($rowMSSQL00['apellido_1'])),
                    'apellido_2'                    => trim(strtoupper($rowMSSQL00['apellido_2'])),
                    'nombre_1'                      => trim(strtoupper($rowMSSQL00['nombre_1'])),
                    'nombre_2'                      => trim(strtoupper($rowMSSQL00['nombre_2'])),
                    'nombre_completo'               => trim(strtoupper($rowMSSQL00['nombre_completo'])),
                    'tipo_sexo_codigo'              => trim(strtoupper($rowMSSQL00['tipo_sexo_codigo'])),
                    'tipo_sexo_nombre'              => trim(strtoupper($tipo_sexo_nombre)),
                    'estado_civil_codigo'           => trim(strtoupper($rowMSSQL00['estado_civil_codigo'])),
                    'estado_civil_nombre'           => trim(strtoupper($estado_civil_nombre)),
                    'email'                         => trim(strtolower($rowMSSQL00['email'])),
                    'fecha_nacimiento'              => $rowMSSQL00['fecha_nacimiento'],
                    'fecha_nacimiento_2'            => date("d/m/Y", strtotime($rowMSSQL00['fecha_nacimiento'])),
                    'cargo_codigo'                  => $rowMSSQL00['cargo_codigo'],
                    'cargo_nombre'                  => trim(strtoupper($rowMSSQL00['cargo_nombre'])),
                    'gerencia_codigo'               => $rowMSSQL00['gerencia_codigo'],
                    'gerencia_nombre'               => trim(strtoupper($rowMSSQL00['gerencia_nombre'])),
                    'departamento_codigo'           => $rowMSSQL00['departamento_codigo'],
                    'departamento_nombre'           => trim(strtoupper($rowMSSQL00['departamento_nombre'])),
                    'superior_cargo_codigo'         => $rowMSSQL00['superior_cargo_codigo'],
                    'superior_cargo_nombre'         => trim(strtoupper($rowMSSQL00['superior_cargo_nombre']))
                );

                $result[]   = $detalle;
            }

            if (isset($result)){
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                $detalle    = array(
                    'documento'                     => '',
                    'apellido_1'                    => '',
                    'apellido_2'                    => '',
                    'nombre_1'                      => '',
                    'nombre_2'                      => '',
                    'nombre_completo'               => '',
                    'tipo_sexo_codigo'              => '',
                    'tipo_sexo_nombre'              => '',
                    'estado_civil_codigo'           => '',
                    'estado_civil_nombre'           => '',
                    'email'                         => '',
                    'fecha_nacimiento'              => '',
                    'fecha_nacimiento_2'            => '',
                    'cargo_codigo'                  => '',
                    'cargo_nombre'                  => '',
                    'gerencia_codigo'               => '',
                    'gerencia_nombre'               => '',
                    'departamento_codigo'           => '',
                    'departamento_nombre'           => '',
                    'superior_cargo_codigo'         => '',
                    'superior_cargo_nombre'         => ''
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

    $app->get('/v1/200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql00  = "SELECT
                a.CedulaEmpleado            AS          documento,
                a.ApellidoPaterno           AS          apellido_1,
                a.ApellidoMaterno           AS          apellido_2,
                a.PrimerNombre              AS          nombre_1,
                a.SegundoNombre             AS          nombre_2,
                a.NombreEmpleado            AS          nombre_completo,
                a.Sexo                      AS          tipo_sexo_codigo,
                a.EstadoCivil               AS          estado_civil_codigo,
                a.Email                     AS          email,
                a.FechaNacimiento           AS          fecha_nacimiento,
                a.CodigoCargo               AS          cargo_codigo,
                a.Cargo                     AS          cargo_nombre,
                a.CodigoGerencia            AS          gerencia_codigo,
                a.Gerencia                  AS          gerencia_nombre,
                a.CodigoDepto               AS          departamento_codigo,
                a.Departamento              AS          departamento_nombre,         
                a.CodCargoSuperior          AS          superior_cargo_codigo,
                a.NombreCargoSuperior       AS          superior_cargo_nombre

                FROM [CSF_PRUEBA].[dbo].[empleados_AxisONE] a

                WHERE a.CedulaEmpleado = ?";

            try {
                $connMSSQL  = getConnectionMSSQL();

                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01]);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    switch ($rowMSSQL00['tipo_sexo_codigo']) {
                        case 'M':
                            $tipo_sexo_nombre = 'MASCULINO';
                            break;
                        
                        case 'F':
                            $tipo_sexo_nombre = 'FEMENINO';
                            break;
                    }

                    switch ($rowMSSQL00['estado_civil_codigo']) {
                        case 'S':
                            $estado_civil_nombre = 'SOLTERO/A';
                            break;
                        
                        case 'C':
                            $estado_civil_nombre = 'CASADO/A';
                            break;

                        case 'D':
                            $estado_civil_nombre = 'DIVORCIADO/A';
                            break;

                        case 'V':
                            $estado_civil_nombre = 'VIUDO/A';
                            break;
                    }

                    $detalle    = array(
                        'documento'                     => $rowMSSQL00['documento'],
                        'apellido_1'                    => trim(strtoupper($rowMSSQL00['apellido_1'])),
                        'apellido_2'                    => trim(strtoupper($rowMSSQL00['apellido_2'])),
                        'nombre_1'                      => trim(strtoupper($rowMSSQL00['nombre_1'])),
                        'nombre_2'                      => trim(strtoupper($rowMSSQL00['nombre_2'])),
                        'nombre_completo'               => trim(strtoupper($rowMSSQL00['nombre_completo'])),
                        'tipo_sexo_codigo'              => trim(strtoupper($rowMSSQL00['tipo_sexo_codigo'])),
                        'tipo_sexo_nombre'              => trim(strtoupper($tipo_sexo_nombre)),
                        'estado_civil_codigo'           => trim(strtoupper($rowMSSQL00['estado_civil_codigo'])),
                        'estado_civil_nombre'           => trim(strtoupper($estado_civil_nombre)),
                        'email'                         => trim(strtolower($rowMSSQL00['email'])),
                        'fecha_nacimiento'              => $rowMSSQL00['fecha_nacimiento'],
                        'fecha_nacimiento_2'            => date("d/m/Y", strtotime($rowMSSQL00['fecha_nacimiento'])),
                        'cargo_codigo'                  => $rowMSSQL00['cargo_codigo'],
                        'cargo_nombre'                  => trim(strtoupper($rowMSSQL00['cargo_nombre'])),
                        'gerencia_codigo'               => $rowMSSQL00['gerencia_codigo'],
                        'gerencia_nombre'               => trim(strtoupper($rowMSSQL00['gerencia_nombre'])),
                        'departamento_codigo'           => $rowMSSQL00['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL00['departamento_nombre'])),
                        'superior_cargo_codigo'         => $rowMSSQL00['superior_cargo_codigo'],
                        'superior_cargo_nombre'         => trim(strtoupper($rowMSSQL00['superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'documento'                     => '',
                        'apellido_1'                    => '',
                        'apellido_2'                    => '',
                        'nombre_1'                      => '',
                        'nombre_2'                      => '',
                        'nombre_completo'               => '',
                        'tipo_sexo_codigo'              => '',
                        'tipo_sexo_nombre'              => '',
                        'estado_civil_codigo'           => '',
                        'estado_civil_nombre'           => '',
                        'email'                         => '',
                        'fecha_nacimiento'              => '',
                        'fecha_nacimiento_2'            => '',
                        'cargo_codigo'                  => '',
                        'cargo_nombre'                  => '',
                        'gerencia_codigo'               => '',
                        'gerencia_nombre'               => '',
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => '',
                        'superior_cargo_codigo'         => '',
                        'superior_cargo_nombre'         => ''
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
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->get('/v1/200/colaborador/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql01  = "SELECT
                a.CedulaEmpleado            AS          documento,
                a.ApellidoPaterno           AS          apellido_1,
                a.ApellidoMaterno           AS          apellido_2,
                a.PrimerNombre              AS          nombre_1,
                a.SegundoNombre             AS          nombre_2,
                a.NombreEmpleado            AS          nombre_completo,
                a.Sexo                      AS          tipo_sexo_codigo,
                a.EstadoCivil               AS          estado_civil_codigo,
                a.Email                     AS          email,
                a.FechaNacimiento           AS          fecha_nacimiento,
                a.CodigoCargo               AS          cargo_codigo,
                a.Cargo                     AS          cargo_nombre,
                a.CodigoGerencia            AS          gerencia_codigo,
                a.Gerencia                  AS          gerencia_nombre,
                a.CodigoDepto               AS          departamento_codigo,
                a.Departamento              AS          departamento_nombre,         
                a.CodCargoSuperior          AS          superior_cargo_codigo,
                a.NombreCargoSuperior       AS          superior_cargo_nombre

                FROM [CSF_PRUEBA].[dbo].[empleados_AxisONE] a
                INNER JOIN [CSF_PRUEBA].[dbo].[empleados_AxisONE] b ON a.CodCargoSuperior = b.CodigoCargo

                WHERE b.CedulaEmpleado = ?";

            try {
                $connMSSQL  = getConnectionMSSQL();
                
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([$val01]);

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                    switch ($rowMSSQL01['tipo_sexo_codigo']) {
                        case 'M':
                            $tipo_sexo_nombre = 'MASCULINO';
                            break;
                        
                        case 'F':
                            $tipo_sexo_nombre = 'FEMENINO';
                            break;
                    }

                    switch ($rowMSSQL01['estado_civil_codigo']) {
                        case 'S':
                            $estado_civil_nombre = 'SOLTERO/A';
                            break;
                        
                        case 'C':
                            $estado_civil_nombre = 'CASADO/A';
                            break;

                        case 'D':
                            $estado_civil_nombre = 'DIVORCIADO/A';
                            break;

                        case 'V':
                            $estado_civil_nombre = 'VIUDO/A';
                            break;
                    }

                    $detalle    = array(
                        'documento'                     => $rowMSSQL01['documento'],
                        'apellido_1'                    => trim(strtoupper($rowMSSQL01['apellido_1'])),
                        'apellido_2'                    => trim(strtoupper($rowMSSQL01['apellido_2'])),
                        'nombre_1'                      => trim(strtoupper($rowMSSQL01['nombre_1'])),
                        'nombre_2'                      => trim(strtoupper($rowMSSQL01['nombre_2'])),
                        'nombre_completo'               => trim(strtoupper($rowMSSQL01['nombre_completo'])),
                        'tipo_sexo_codigo'              => trim(strtoupper($rowMSSQL01['tipo_sexo_codigo'])),
                        'tipo_sexo_nombre'              => trim(strtoupper($tipo_sexo_nombre)),
                        'estado_civil_codigo'           => trim(strtoupper($rowMSSQL01['estado_civil_codigo'])),
                        'estado_civil_nombre'           => trim(strtoupper($estado_civil_nombre)),
                        'email'                         => trim(strtolower($rowMSSQL01['email'])),
                        'fecha_nacimiento'              => $rowMSSQL01['fecha_nacimiento'],
                        'fecha_nacimiento_2'            => date("d/m/Y", strtotime($rowMSSQL01['fecha_nacimiento'])),
                        'cargo_codigo'                  => $rowMSSQL01['cargo_codigo'],
                        'cargo_nombre'                  => trim(strtoupper($rowMSSQL01['cargo_nombre'])),
                        'gerencia_codigo'               => $rowMSSQL01['gerencia_codigo'],
                        'gerencia_nombre'               => trim(strtoupper($rowMSSQL01['gerencia_nombre'])),
                        'departamento_codigo'           => $rowMSSQL01['departamento_codigo'],
                        'departamento_nombre'           => trim(strtoupper($rowMSSQL01['departamento_nombre'])),
                        'superior_cargo_codigo'         => $rowMSSQL01['superior_cargo_codigo'],
                        'superior_cargo_nombre'         => trim(strtoupper($rowMSSQL01['superior_cargo_nombre']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'documento'                     => '',
                        'apellido_1'                    => '',
                        'apellido_2'                    => '',
                        'nombre_1'                      => '',
                        'nombre_2'                      => '',
                        'nombre_completo'               => '',
                        'tipo_sexo_codigo'              => '',
                        'tipo_sexo_nombre'              => '',
                        'estado_civil_codigo'           => '',
                        'estado_civil_nombre'           => '',
                        'email'                         => '',
                        'fecha_nacimiento'              => '',
                        'fecha_nacimiento_2'            => '',
                        'cargo_codigo'                  => '',
                        'cargo_nombre'                  => '',
                        'gerencia_codigo'               => '',
                        'gerencia_nombre'               => '',
                        'departamento_codigo'           => '',
                        'departamento_nombre'           => '',
                        'superior_cargo_codigo'         => '',
                        'superior_cargo_nombre'         => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
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

    $app->get('/v1/200/solicitud/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val01      = $request->getAttribute('codigo');
        
        if (isset($val01)) {
            $sql01  = "SELECT
                a.SOLFICCOD         AS          solicitud_codigo,
                a.SOLFICEST         AS          solicitud_estado_codigo,
                a.SOLFICDOC         AS          solicitud_documento,
                a.SOLFICFE1         AS          solicitud_fecha_desde,
                a.SOLFICFE2         AS          solicitud_fecha_hasta,
                a.SOLFICFEC         AS          solicitud_fecha_cantidad,
                a.SOLFICHO1         AS          solicitud_hora_desde,
                a.SOLFICHO2         AS          solicitud_hora_hasta,
                a.SOLFICHOC         AS          solicitud_hora_cantidad,
                a.SOLFICOB1         AS          solicitud_observacion_colaborador,
                a.SOLFICOB2         AS          solicitud_observacion_aprobador,
                a.SOLFICOB3         AS          solicitud_observacion_talento,
                a.SOLFICUSC         AS          solicitud_usuario_colaborador,
                a.SOLFICFHC         AS          solicitud_fecha_hora_colaborador,
                a.SOLFICIPC         AS          solicitud_ip_colaborador,         
                a.SOLFICUSA         AS          solicitud_usuario_aprobador,
                a.SOLFICFHA         AS          solicitud_fecha_hora_aprobador,
                a.SOLFICIPA         AS          solicitud_ip_aprobador,
                a.SOLFICUST         AS          solicitud_usuario_talento,
                a.SOLFICFHT         AS          solicitud_fecha_hora_talento,
                a.SOLFICIPT         AS          solicitud_ip_talento,
                a.SOLFICAUS         AS          auditoria_usuario,
                a.SOLFICAFH         AS          auditoria_fecha_hora,
                a.SOLFICAIP         AS          auditoria_ip,

                b.DOMPARCOD         AS          tipo_solicitud_codigo

                FROM [CSF_PERMISOS].[adm].[SOLFIC] a
                INNER JOIN [CSF_PERMISOS].[adm].[DOMPAR] b ON a.SOLFICTST = b.DOMPARCOD

                WHERE a.SOLFICDOC = ?";

            try {
                $connMSSQL  = getConnectionMSSQL();
                
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([$val01]);

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                    switch ($rowMSSQL01['solicitud_estado_codigo']) {
                        case 'I':
                            $solicitud_estado_nombre = 'INGRESADO';
                            break;
                        
                        case 'A':
                            $solicitud_estado_nombre = 'AUTORIZADO';
                            break;
                        
                        case 'P':
                            $solicitud_estado_nombre = 'APROBADO';
                            break;
                    }

                    $detalle    = array(
                        'solicitud_codigo'                  => $rowMSSQL01['solicitud_codigo'],
                        'solicitud_estado_codigo'           => $rowMSSQL01['solicitud_estado_codigo'],
                        'solicitud_estado_nombre'           => trim(strtoupper($solicitud_estado_nombre)),
                        'solicitud_documento'               => trim(strtoupper($rowMSSQL01['solicitud_documento'])),
                        'solicitud_fecha_desde'             => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_desde'])),
                        'solicitud_fecha_hasta'             => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hasta'])),
                        'solicitud_fecha_cantidad'          => $rowMSSQL01['solicitud_fecha_cantidad'],
                        'solicitud_hora_desde'              => trim(strtoupper($rowMSSQL01['solicitud_hora_desde'])),
                        'solicitud_hora_hasta'              => trim(strtoupper($rowMSSQL01['solicitud_hora_hasta'])),
                        'solicitud_hora_cantidad'           => $rowMSSQL01['solicitud_hora_cantidad'],
                        'solicitud_usuario_colaborador'     => trim(strtoupper($rowMSSQL01['solicitud_usuario_colaborador'])),
                        'solicitud_fecha_hora_colaborador'  => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_colaborador'])),
                        'solicitud_ip_colaborador'          => trim(strtoupper($rowMSSQL01['solicitud_ip_colaborador'])),
                        'solicitud_observacion_colaborador' => trim(strtoupper($rowMSSQL01['solicitud_observacion_colaborador'])),
                        'solicitud_usuario_aprobador'       => trim(strtoupper($rowMSSQL01['solicitud_usuario_aprobador'])),
                        'solicitud_fecha_hora_aprobador'    => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_aprobador'])),
                        'solicitud_ip_aprobador'            => trim(strtoupper($rowMSSQL01['solicitud_ip_aprobador'])),
                        'solicitud_observacion_aprobador'   => trim(strtoupper($rowMSSQL01['solicitud_observacion_aprobador'])),
                        'solicitud_usuario_talento'         => trim(strtoupper($rowMSSQL01['solicitud_usuario_talento'])),
                        'solicitud_fecha_hora_talento'      => date("d/m/Y", strtotime($rowMSSQL01['solicitud_fecha_hora_talento'])),
                        'solicitud_ip_talento'              => trim(strtoupper($rowMSSQL01['solicitud_ip_talento'])),
                        'solicitud_observacion_talento'     => trim(strtoupper($rowMSSQL01['solicitud_observacion_talento'])),
                        'auditoria_usuario'                 => trim(strtoupper($rowMSSQL01['auditoria_usuario'])),
                        'auditoria_fecha_hora'              => date("d/m/Y", strtotime($rowMSSQL01['auditoria_fecha_hora'])),
                        'auditoria_ip'                      => trim(strtoupper($rowMSSQL01['auditoria_ip']))
                    );

                    $result[]   = $detalle;
                }

                if (isset($result)){
                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                } else {
                    $detalle    = array(
                        'solicitud_codigo'                  => '',
                        'solicitud_estado_codigo'           => '',
                        'solicitud_estado_nombre'           => '',
                        'solicitud_documento'               => '',
                        'solicitud_fecha_desde'             => '',
                        'solicitud_fecha_hasta'             => '',
                        'solicitud_fecha_cantidad'          => '',
                        'solicitud_hora_desde'              => '',
                        'solicitud_hora_hasta'              => '',
                        'solicitud_hora_cantidad'           => '',
                        'solicitud_usuario_colaborador'     => '',
                        'solicitud_fecha_hora_colaborador'  => '',
                        'solicitud_ip_colaborador'          => '',
                        'solicitud_observacion_colaborador' => '',
                        'solicitud_usuario_aprobador'       => '',
                        'solicitud_fecha_hora_aprobador'    => '',
                        'solicitud_ip_aprobador'            => '',
                        'solicitud_observacion_aprobador'   => '',
                        'solicitud_usuario_talento'         => '',
                        'solicitud_fecha_hora_talento'      => '',
                        'solicitud_ip_talento'              => '',
                        'solicitud_observacion_talento'     => '',
                        'auditoria_usuario'                 => '',
                        'auditoria_fecha_hora'              => '',
                        'auditoria_ip'                      => ''
                    );

                    header("Content-Type: application/json; charset=utf-8");
                    $json = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => $detalle), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
                }

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
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