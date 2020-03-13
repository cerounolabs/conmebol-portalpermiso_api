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

        if (isset($val01) && isset($val02) && isset($val03)) {
            try {
                $servidor_LDAP    = "172.16.50.1";
                $dominio_LDAP     = "conmebol.com";
                $dn_LDAP          = "dc=conmebol,dc=com";
                $usuario_LDAP     = $val01;
                $contrasena_LDAP  = $val02;
                $filtro_LDAP      = '(&(objectClass=user)(objectCategory=person)(samaccountname='.$usuario_LDAP.'))';
                $atributo_LDAP    = array('givenname', 'userprincipalname', 'samaccountname', 'sn', 'postalcode', 'thumbnailphoto', 'thumbnail', 'jpegphoto');
                $conectado_LDAP   = ldap_connect($servidor_LDAP);

                ldap_set_option($conectado_LDAP, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($conectado_LDAP, LDAP_OPT_REFERRALS, 0);

                if ($conectado_LDAP) {
                    $autenticado_LDAP = ldap_bind($conectado_LDAP, $usuario_LDAP."@".$dominio_LDAP, $contrasena_LDAP);
                    
                    if ($autenticado_LDAP) {
                        $resultado_LDAP = ldap_search($conectado_LDAP, $dn_LDAP, $filtro_LDAP);
                        $numero_LDAP    = ldap_count_entries($conectado_LDAP, $resultado_LDAP);
                        $entrada_LDAP   = ldap_get_entries($conectado_LDAP, $resultado_LDAP);

                        foreach($entrada_LDAP as $i){
                            foreach($atributo_LDAP as $j){
                                if(isset($i[$j])){
                                    switch ($j) {
                                        case 'givenname':
                                            $user_var01 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'userprincipalname':
                                            $user_var02 = strtolower(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'samaccountname':
                                            $user_var03 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'sn':
                                            $user_var04 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                        case 'postalcode':
                                            $user_var05 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;

                                        case 'thumbnailphoto':
                                            $user_var06 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;

                                        case 'thumbnail':
                                            $user_var08 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;

                                        case 'jpegphoto':
                                            $user_var07 = strtoupper(htmlspecialchars($i[$j][0]));
                                            break;
                                    }
                                }
                            }
                        }

                        $detalle    = array(
                            'user_var01' => $user_var01,
                            'user_var02' => $user_var02,
                            'user_var03' => $user_var03,
                            'user_var04' => $user_var04,
                            'user_var05' => $user_var05,
                            'user_var06' => $user_var06,
                            'user_var07' => $user_var07,
                            'user_var08' => $user_var08,
                        );

                        $reCode     = 200;
                        $reMessage  = 'Success LOGIN';

                        ldap_close($conectado_LDAP);
                    } else {
                        $reCode     = 201;
                        $reMessage  = 'ERROR: Verifique su usuario y su contraseña introducida';
                        $detalle    = array(
                            'user_var01' => '',
                            'user_var02' => '',
                            'user_var03' => '',
                            'user_var04' => '',
                            'user_var05' => '',
                            'user_var06' => '',
                            'user_var07' => '',
                            'user_var08' => ''
                        );
                    }
                } else {
                    $reCode     = 204;
                    $reMessage  = 'ERROR: Inconveniente al acceder al Servidor';
                    $detalle    = array(
                        'user_var01' => '',
                        'user_var02' => '',
                        'user_var03' => '',
                        'user_var04' => '',
                        'user_var05' => '',
                        'user_var06' => '',
                        'user_var07' => '',
                        'user_var08' => ''
                    );
                }

                $result[]   = $detalle;

                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => $reCode, 'status' => 'ok', 'message' => $reMessage, 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } catch (PDOException $e) {
                header("Content-Type: application/json; charset=utf-8");
                $json = json_encode(array('code' => 204, 'status' => 'failure', 'message' => 'Error LOGIN: '.$e), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

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
        $val07      = $request->getParsedBody()['tipo_dia_unidad'];
        $val08      = $request->getParsedBody()['tipo_archivo_adjunto'];
        $val09      = $request->getParsedBody()['tipo_observacion'];

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
            
            $sql01  = "INSERT INTO [adm].[DOMPAR] (DOMPAREST, DOMPARTST, DOMPARORD, DOMPARPC1, DOMPARPC2, DOMPARPC3, DOMPARDIC, DOMPARDIO, DOMPARDIU, DOMPARADJ, DOMPAROBS, DOMPARAUS, DOMPARAFH, DOMPARAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val04]);

                $row00      = $stmtMSSQL00->fetch(PDO::FETCH_ASSOC);
                $DOMPARPC1  = $row00['Code'];
                $DOMPARPC2  = $row00['Name'];
                $DOMPARPC3  = $row00['U_CODIGO'];

                $stmtMSSQL  = $connMSSQL->prepare($sql01);
                $stmtMSSQL->execute([$val01, $val02, $val03, $DOMPARPC1, $DOMPARPC2, $DOMPARPC3, $val05, $val06, $val07, $val08, $val09, $aud01, $aud03]);

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

                    if (!$rowMSSQL03) {
                        $stmtMSSQL04->execute([$DOMPAREST, $DOMPARTST, $DOMPARORD, $rowMSSQL00['tipo_codigo'], $rowMSSQL00['tipo_codigo_nombre'], $rowMSSQL00['tipo_codigo_referencia'], $DOMPARDIC, $DOMPARDIO, $DOMPAROBS, $DOMPARAUS, $DOMPARAIP]);
                    }
                }

                $DOMPARTST  = 'P';
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute();

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                    $stmtMSSQL03->execute([$DOMPARTST, $rowMSSQL01['tipo_codigo'], $rowMSSQL01['tipo_codigo_nombre'], $rowMSSQL01['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!$rowMSSQL03) {
                        $stmtMSSQL04->execute([$DOMPAREST, $DOMPARTST, $DOMPARORD, $rowMSSQL01['tipo_codigo'], $rowMSSQL01['tipo_codigo_nombre'], $rowMSSQL01['tipo_codigo_referencia'], $DOMPARDIC, $DOMPARDIO, $DOMPAROBS, $DOMPARAUS, $DOMPARAIP]);
                    }
                }

                $DOMPARTST  = 'I';
                $stmtMSSQL02= $connMSSQL->prepare($sql02);
                $stmtMSSQL02->execute();

                while ($rowMSSQL02 = $stmtMSSQL02->fetch()) {
                    $stmtMSSQL03->execute([$DOMPARTST, $rowMSSQL02['tipo_codigo'], $rowMSSQL02['tipo_codigo_nombre'], $rowMSSQL02['tipo_codigo_referencia']]);
                    $rowMSSQL03 = $stmtMSSQL03->fetch(PDO::FETCH_ASSOC);

                    if (!$rowMSSQL03) {
                        $stmtMSSQL04->execute([$DOMPAREST, $DOMPARTST, $DOMPARORD, $rowMSSQL02['tipo_codigo'], $rowMSSQL02['tipo_codigo_nombre'], $rowMSSQL02['tipo_codigo_referencia'], $DOMPARDIC, $DOMPARDIO, $DOMPAROBS, $DOMPARAUS, $DOMPARAIP]);
                    }
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success PROCESAR', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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

    $app->post('/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02      = $request->getParsedBody()['tipo_solicitud_codigo'];
        $val03      = $request->getParsedBody()['solicitud_documento'];
        $val04      = $request->getParsedBody()['solicitud_fecha_desde'];
        $val05      = $request->getParsedBody()['solicitud_fecha_hasta'];
        $val06      = $request->getParsedBody()['solicitud_fecha_cantidad'];
        $val07      = $request->getParsedBody()['solicitud_hora_desde'];
        $val08      = $request->getParsedBody()['solicitud_hora_hasta'];
        $val09      = $request->getParsedBody()['solicitud_hora_cantidad'];
        $val10      = $request->getParsedBody()['solicitud_adjunto'];
        $val11      = $request->getParsedBody()['solicitud_observacion_colaborador'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

        if (isset($val01) && isset($val02) && isset($val04)) {        
            $sql00  = "INSERT INTO [adm].[SOLFIC] (SOLFICEST, SOLFICTST, SOLFICDOC, SOLFICFE1, SOLFICFE2, SOLFICFEC, SOLFICHO1, SOLFICHO2, SOLFICHOC, SOLFICADJ, SOLFICOB1, SOLFICUSC, SOLFICFHC, SOLFICIPC, SOLFICAUS, SOLFICAFH, SOLFICAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL00= $connMSSQL->prepare($sql00);
                $stmtMSSQL00->execute([$val01, $val02, $val03, $val04, $val05, $val06, $val07, $val08, $val09, $val10, $val11, $aud01, $aud03, $aud01, $aud03]);

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

                $stmtMSSQL00->closeCursor();
                $stmtMSSQL00 = null;
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

    $app->post('/v1/200/detalle', function($request) {
        require __DIR__.'/../src/connect.php';

        $val01      = $request->getParsedBody()['solicitud_codigo'];

        $aud01      = $request->getParsedBody()['auditoria_usuario'];
        $aud02      = $request->getParsedBody()['auditoria_fecha_hora'];
        $aud03      = $request->getParsedBody()['auditoria_ip'];

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

                b.DOMPARCOD         AS          tipo_permiso_codigo,
                b.DOMPAREST         AS          tipo_estado_codigo,
                b.DOMPARTST         AS          tipo_solicitud_codigo,
                b.DOMPARPC1         AS          tipo_permiso_codigo1,
                b.DOMPARPC2         AS          tipo_permiso_codigo2,
                b.DOMPARPC3         AS          tipo_permiso_codigo3,
                b.DOMPARORD         AS          tipo_orden_numero,
                b.DOMPARDIC         AS          tipo_dia_cantidad,
                b.DOMPARDIO         AS          tipo_dia_corrido,
                b.DOMPARDIU         AS          tipo_dia_unidad,
                b.DOMPARADJ         AS          tipo_archivo_adjunto,
                b.DOMPAROBS         AS          tipo_observacion

                FROM [CSF_PERMISOS].[adm].[SOLFIC] a
                INNER JOIN [CSF_PERMISOS].[adm].[DOMPAR] b ON a.SOLFICTST = b.DOMPARCOD
                
                WHERE a.SOLFICCOD = ?";

            $sql03  = "INSERT INTO [CSF_PERMISOS].[adm].[SOLAXI] (SOLAXICAB, SOLAXIEST, SOLAXISOL, SOLAXIDOC, SOLAXIFED, SOLAXIFEH, SOLAXIAPD, SOLAXIAPH, SOLAXICAN, SOLAXITIP, SOLAXIDIA, SOLAXIUNI, SOLAXICOM, SOLAXIIDP, SOLAXICON, SOLAXICLA, SOLAXILIN, SOLAXIORI, SOLAXIGRU, SOLAXIAUS, SOLAXIAFH, SOLAXIAIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";

            try {
                $connMSSQL  = getConnectionMSSQL();
                $stmtMSSQL01= $connMSSQL->prepare($sql01);
                $stmtMSSQL01->execute([$val01]);

                $stmtMSSQL03= $connMSSQL->prepare($sql03);

                while ($rowMSSQL01 = $stmtMSSQL01->fetch()) {
                    switch ($rowMSSQL01['tipo_solicitud_codigo']) {
                        case 'L':
                            $tipo_solicitud_nombre  = 'LICENCIA';
                            $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre,  U_CODINA AS tipo_permiso_codigo, U_TIPO AS tipo_permiso_valor FROM [CSF_PRUEBA].[dbo].[@A1A_TILC] WHERE U_CODIGO = ?";
                            break;
                        
                        case 'P':
                            $tipo_solicitud_nombre  = 'PERMISO';
                            $sql02                  = "SELECT U_NOMBRE AS tipo_permiso_nombre, U_CODINA AS tipo_permiso_codigo, U_CALIFICA AS tipo_permiso_valor FROM [CSF_PRUEBA].[dbo].[@A1A_TIPE] WHERE U_CODIGO = ?";
                            break;
        
                        case 'I':
                            $tipo_solicitud_nombre  = 'INASISTENCIA';
                            $sql02                  = "SELECT U_DESAMP AS tipo_permiso_nombre, U_CODIGO AS tipo_permiso_codigo, U_IDENT AS tipo_permiso_valor FROM [CSF_PRUEBA].[dbo].[@A1A_TIIN] WHERE U_CODIGO = ?";
                            break;
                    }

                    $stmtMSSQL02= $connMSSQL->prepare($sql02);
                    $stmtMSSQL02->execute([trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3']))]);
                    $rowMSSQL02 = $stmtMSSQL02->fetch(PDO::FETCH_ASSOC);

                    $SOLAXICAB  = $val01;
                    $SOLAXIEST  = 'P';
                    $SOLAXIDOC  = trim(strtoupper($rowMSSQL01['solicitud_documento']));
                    $SOLAXIFED  = $rowMSSQL01['solicitud_fecha_desde'];
                    $SOLAXIFEH  = $rowMSSQL01['solicitud_fecha_hasta'];
                    $SOLAXIAPD  = $rowMSSQL01['solicitud_fecha_desde'];
                    $SOLAXIAPH  = $rowMSSQL01['solicitud_fecha_hasta'];
                    $SOLAXICAN  = 0;
                    $SOLAXITIP  = trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3']));
                    $SOLAXIDIA  = 1;
                    $SOLAXIUNI  = trim(strtoupper($rowMSSQL01['tipo_dia_unidad']));
                    $SOLAXICOM  = trim(strtoupper($rowMSSQL02['tipo_permiso_nombre']));
                    $SOLAXIIDP  = '';
                    $SOLAXICON  = '00:00';
                    $SOLAXICLA  = trim(strtoupper($rowMSSQL02['tipo_permiso_valor']));
                    $SOLAXISOL  = trim(strtoupper($rowMSSQL01['tipo_solicitud_codigo']));
                    $SOLAXILIN  = '';
                    $SOLAXIORI  = '';
                    $SOLAXIGRU  = '';
                    $SOLAXIAUS  = trim(strtoupper($aud01));
                    $SOLAXIAFH  = $aud02;
                    $SOLAXIAIP  = trim(strtoupper($aud03));

                    if ($SOLAXIFED == $SOLAXIFEH) {
                        $SOLAXICAN = 1;
                    } else {
                        $auxFech   = $SOLAXIFED;

                        while ($SOLAXIFEH >= $auxFech) {
                            $dia = date('w', strtotime($auxFech));
    
                            if ($dia >= 1 && $dia <= 5) {
                                $SOLAXICAN = $SOLAXICAN + 1;
                            } else {
                                if ($rowMSSQL01['tipo_dia_corrido'] == 'S') {
                                    $SOLAXICAN = $SOLAXICAN + 1;
                                }
                            }
    
                            $auxFech = date('Y-m-d', strtotime('+1 day', strtotime($auxFech)));
                        }
                    }

                    if ($rowMSSQL01['tipo_dia_unidad'] == 'H') {
                        $date1      = new DateTime('Y-m-d '.$rowMSSQL01['solicitud_hora_desde'].':00');
                        $date2      = new DateTime('Y-m-d '.$rowMSSQL01['solicitud_hora_hasta'].':00');
                        $diff       = $date1->diff($date2);
                        $auxHor     = '';
                        $auxHor     .= ($diff->invert == 1) ? ' - ' : '';

                        if ($diff->h > 0) {
                            $auxHor .= ($diff->h > 1) ? $diff->h.':' : $diff->h . ':';
                        }
                        
                        if ($diff->i > 0) {
                            $auxHor .= ($diff->i > 1) ? $diff->i.':00' : $diff->i . ':00';
                        }

                        $SOLAXICON  = get_format($auxHor);
                    }

                    if (trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3'])) == 'DSM' && trim(strtoupper($rowMSSQL01['tipo_solicitud_codigo'])) == 'I') {
                        $SOLAXISOL  = 'V';
                        $SOLAXITIP  = 'VAC';
                        $SOLAXILIN  = 'UV';
                    }

                    $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIAUS, $SOLAXIAIP]);
                    
                    $auxFech    = $SOLAXIFEH;
                    $SOLAXICAN  = 1;
                    $SOLAXITIP  =  trim(strtoupper($rowMSSQL02['tipo_permiso_codigo']));
                    $SOLAXIGRU  = $connMSSQL->lastInsertId();

                    if (trim(strtoupper($rowMSSQL01['tipo_permiso_codigo3'])) == 'DSM' && trim(strtoupper($rowMSSQL01['tipo_solicitud_codigo'])) == 'I') {
                        $SOLAXISOL  = 'I';
                        $SOLAXITIP  = 'DSM';
                        $SOLAXILIN  = '';
                    }

                    if ($SOLAXIFED == $auxFech) {
                        $SOLAXIFEH  = $SOLAXIFED;
                        $SOLAXIAPH  = $SOLAXIFED;

                        $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIAUS, $SOLAXIAIP]);
                    } else {
                        while ($auxFech >= $SOLAXIFED) {
                            $dia        = date('w', strtotime($SOLAXIFED));
                            $SOLAXIFEH  = $SOLAXIFED;
                            $SOLAXIAPH  = $SOLAXIFED;
    
                            if ($dia >= 1 && $dia <= 5) {
                                $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIAUS, $SOLAXIAIP]);
                            } else {
                                if ($rowMSSQL01['tipo_dia_corrido'] == 'S') {
                                    $stmtMSSQL03->execute([$SOLAXICAB, $SOLAXIEST, $SOLAXISOL, $SOLAXIDOC, $SOLAXIFED, $SOLAXIFEH, $SOLAXIAPD, $SOLAXIAPH, $SOLAXICAN, $SOLAXITIP, $SOLAXIDIA, $SOLAXIUNI, $SOLAXICOM, $SOLAXIIDP, $SOLAXICON, $SOLAXICLA, $SOLAXILIN, $SOLAXIORI, $SOLAXIGRU, $SOLAXIAUS, $SOLAXIAIP]);
                                }
                            }
    
                            $SOLAXIFED = date('Y-m-d', strtotime('+1 day', strtotime($SOLAXIFED)));
                        }
                    }
                }

                header("Content-Type: application/json; charset=utf-8");
                $json       = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Success INSERT', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);

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