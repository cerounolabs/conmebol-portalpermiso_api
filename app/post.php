<?php
    $app->post('/v1/login', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['usuario_var01'];
        $val02      = $request->getParsedBody()['usuario_var02'];
        $val03      = $request->getParsedBody()['usuario_var03'];
        $val04      = $request->getParsedBody()['usuario_var04'];
        $val05      = $request->getParsedBody()['usuario_var05'];
        $val06      = $request->getParsedBody()['usuario_var06'];
        $val07      = $request->getParsedBody()['usuario_var07'];
        $server     = "ldap://172.16.50.1";

        if (isset($val01) && isset($val02) && isset($val03)) {
            try {
                $ldap_conn  = ldap_connect($server);
                $ldap_rdn   = $val01;

                ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

                if(@ldap_bind($ldap_conn, $ldap_rdn, $val02)){
                    $result = "Si se conecto";
                } else {
                    $result = "No se conecto";
                }

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success SELECT', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error LOGIN: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        $connMYSQL  = null;
        
        return $json;
    });

    $app->post('/v1/100', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_solicitud_codigo'];
        $val03      = $request->getParsedBody()['tipo_orden_numero'];
        $val04      = $request->getParsedBody()['tipo_permiso_codigo'];
        $val05      = $request->getParsedBody()['tipo_dia_cantidad'];
        $val06      = $request->getParsedBody()['tipo_dia_corrido'];
        $val07      = $request->getParsedBody()['tipo_observacion'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04)) {    
            $sql00  = "";

            switch ($val02) {
                case 'L':
                    $sql00  = "SELECT Code, Name, U_CODIGO FROM dbo.[@A1A_TILC] WHERE Code = ?";
                    break;
                
                case 'P':
                    $sql00  = "SELECT Code, Name, U_CODIGO FROM dbo.[@A1A_TIPE] WHERE Code = ?";
                    break;

                case 'I':
                    $sql00  = "SELECT Code, Name, U_CODIGO FROM dbo.[@A1A_TIIN] WHERE Code = ?";
                    break;
            }        
            
            $sql01  = "INSERT INTO [adm].[DOMPAR] (DOMPAREST, DOMPARTST, DOMPARORD, DOMPARPC1, DOMPARPC2, DOMPARPC3, DOMPARDIC, DOMPARDIO, DOMPAROBS, DOMPARAUS, DOMPARAFH, DOMPARAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val04]);

                $row00      = $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                $DOMPARPC1  = $row00['Code'];
                $DOMPARPC2  = $row00['Name'];
                $DOMPARPC3  = $row00['U_CODIGO'];

                $stmtMSSQL  = $connMSSQL->prepare($sql01);
                $stmtMSSQL->execute([$val01, $val02, $val03, $DOMPARPC1, $DOMPARPC2, $DOMPARPC3, $val05, $val06, $val07, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });

    $app->post('/v1/100/procesar', function($request) {
        require __DIR__.'/../src/connect.php';

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($aud01) && isset($aud02) && isset($aud03)) {
            $DOMPAREST  = 'A';
            $DOMPARORD  = 0;
            $DOMPARDIC  = 0;
            $DOMPARDIO  = '';
            $DOMPAROBS  = '';
            $DOMPARAUS  = $aud01;
            $DOMPARAIP  = $aud03;

            $sql00      = "SELECT a.CODE AS tipo_codigo, a.NAME AS tipo_codigo_nombre, a.U_CODIGO AS tipo_codigo_referencia FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] a ORDER BY a.U_CODIGO";
            $sql01      = "SELECT a.CODE AS tipo_codigo, a.NAME AS tipo_codigo_nombre, a.U_CODIGO AS tipo_codigo_referencia FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] a ORDER BY a.U_CODIGO";
            $sql02      = "SELECT a.CODE AS tipo_codigo, a.NAME AS tipo_codigo_nombre, a.U_CODIGO AS tipo_codigo_referencia FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] a ORDER BY a.U_CODIGO";
            $sql03      = "SELECT * FROM [adm].[DOMPAR] WHERE DOMPARTST = ? AND DOMPARPC1 = ? AND DOMPARPC2 = ? AND DOMPARPC3 = ?";
            $sql04      = "INSERT INTO [CSF_PERMISOS].[adm].[DOMPAR] (DOMPAREST, DOMPARTST, DOMPARORD, DOMPARPC1, DOMPARPC2, DOMPARPC3, DOMPARDIC, DOMPARDIO, DOMPAROBS, DOMPARAUS, DOMPARAFH, DOMPARAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();

                $DOMPARTST  = 'L';
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute();

                $stmtMSSQL03= $connMSSQL->prepare($sql03);
                $stmtMSSQL04= $connMSSQL->prepare($sql04);

                while ($rowMSSQL00 = $stmtMSSQL00->fetch()) {
                    $stmtMSSQL03->execute([$DOMPARTST, $rowMSSQL00['tipo_codigo'], $rowMSSQL00['tipo_codigo_nombre'], $rowMSSQL00['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!isset($rowMSSQL03)) {
                        $stmtMSSQL04->execute([$DOMPAREST, $DOMPARTST, $DOMPARORD, $rowMSSQL00['tipo_codigo'], $rowMSSQL00['tipo_codigo_nombre'], $rowMSSQL00['tipo_codigo_referencia'], $DOMPARDIC, $DOMPARDIO, $DOMPAROBS, $DOMPARAUS, $DOMPARAIP]);
                    }
                }

                $DOMPARTST  = 'P';
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                    $stmtMSSQL03->execute([$DOMPARTST, $rowMSSQL01['tipo_codigo'], $rowMSSQL01['tipo_codigo_nombre'], $rowMSSQL01['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!isset($rowMSSQL03)) {
                        $stmtMSSQL04->execute([$DOMPAREST, $DOMPARTST, $DOMPARORD, $rowMSSQL01['tipo_codigo'], $rowMSSQL01['tipo_codigo_nombre'], $rowMSSQL01['tipo_codigo_referencia'], $DOMPARDIC, $DOMPARDIO, $DOMPAROBS, $DOMPARAUS, $DOMPARAIP]);
                    }
                }

                $DOMPARTST  = 'I';
                $stmtMSSQL02= $connMSSQL->prepare($sql02);
                $stmtMSSQL02->execute();

                while ($rowMSSQL02 = $stmtMSSQL02->fetch()) {
                    $stmtMSSQL03->execute([$DOMPARTST, $rowMSSQL02['tipo_codigo'], $rowMSSQL02['tipo_codigo_nombre'], $rowMSSQL02['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!isset($rowMSSQL03)) {
                        $stmtMSSQL04->execute([$DOMPAREST, $DOMPARTST, $DOMPARORD, $rowMSSQL02['tipo_codigo'], $rowMSSQL02['tipo_codigo_nombre'], $rowMSSQL02['tipo_codigo_referencia'], $DOMPARDIC, $DOMPARDIO, $DOMPAROBS, $DOMPARAUS, $DOMPARAIP]);
                    }
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;

                $stmtMSSQL01->closeCursor();
                $stmtMSSQL01 = null;

                $stmtMSSQL02->closeCursor();
                $stmtMSSQL02 = null;

                $stmtMSSQL03->closeCursor();
                $stmtMSSQL03 = null;

                $stmtMSSQL04->closeCursor();
                $stmtMSSQL04 = null;
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error INSERT: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $connMSSQL  = null;
        
        return $json;
    });