<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

switch (Routes::_gi()->_depth(1)) {

    case Util::page_o:

//        if (!Sessions::_gi()->_logged_in())
//            Util::_redirect();

        switch (Routes::_gi()->_depth(2)) {

            case Util::page_masuk:

                $_email = Util::_arr($_POST, 'email');
                $_password = Util::_arr($_POST, 'password');
                $_level = Util::_arr($_POST, 'level');

                $_id = COperator::_gi()->_login($_email, $_password, $_level);

                if (!$_id)
                    Util::_redirect(
                        Util::_a(Util::page_masuk . DS . Util::dir_operator . DS . Util::status_failed)
                    );
                else {
                    $_obj_operator = COperator::_gi()->_get($_id);
                    Authentications::_gi()->_set($_obj_operator->getOperatorFakultas(), $_level, $_email, $_obj_operator->getOperatorNama());
                    switch ($_level) {
                        case Authentications::SESSION_OPERATOR_LEVEL:
                            Util::_redirect(
                                Util::_a_o(Util::o_dashboard)
                            );
                            break;
                        case Authentications::SESSION_DOSEN_LEVEL:
                            Util::_redirect(
                                Util::_a_d(Util::d_penelitian)
                            );
                            break;
                        case Authentications::SESSION_VERIFIKATOR_LEVEL:
                        Util::_redirect(
                            Util::_a_v(Util::v_jurnal)
                        );
                        break;
                    }
                }
                break;

            case Util::o_peneliti_asing:

                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $obj_asing = new MAsing();
                        $obj_asing->_init($_REQUEST);
                        CAsing::_gi()->_insert($obj_asing);

                        Util::_redirect(
                            Util::_a_o(Util::o_peneliti_asing . DS . Util::status_success . DS . Util::action_add)
                        );
                        break;

                    case Util::action_edit:
                        $obj_asing = CAsing::_gi()->_get(Routes::_gi()->_depth(4));
                        $obj_asing->_init($_REQUEST);

                        CAsing::_gi()->_update($obj_asing);
                        Util::_redirect(
                            Util::_a_o(Util::o_peneliti_asing . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;


                }
                break;

            case Util::o_staf:

                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $obj_staf = new MStaf();
                        $obj_staf->_init($_REQUEST);
                        CStaf::_gi()->_insert($obj_staf);

                        Util::_redirect(
                            Util::_a_o(Util::o_staf . DS . Util::status_success . DS . Util::action_add)
                        );
                        break;

                    case Util::action_edit:
                        $obj_staf = CStaf::_gi()->_get(Routes::_gi()->_depth(4));
                        $obj_staf->_init($_REQUEST);

                        CStaf::_gi()->_update($obj_staf);
                        Util::_redirect(
                            Util::_a_o(Util::o_staf . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;

                }
                break;

            case Util::o_ditlibmas:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $obj_ditlibmas = new MDitlibmas();
                        $obj_ditlibmas->_init($_REQUEST);

                        CDitlibmas::_gi()->_insert($obj_ditlibmas);

                        unset($_REQUEST['ditlibmas_id']);

                        $obj = CDitlibmas::_gi()->_gets($_REQUEST);

                        foreach ($obj as $item) {
                            CPeneliti::_gi()->update_peneliti($item->getDitlibmasId(), $item->getDitlibmasFakultas(), Util::o_ditlibmas);
                            CNonpeneliti::_gi()->update_nonpeneliti($item->getDitlibmasId(), $item->getDitlibmasFakultas(), Util::o_ditlibmas);
                        }

                        Util::_redirect(
                            Util::_a_o(Util::o_ditlibmas . DS . Util::status_success . DS . Util::action_add)
                        );

                        break;

                    case Util::action_edit:
                        $obj_ditlibmas = CDitlibmas::_gi()->_get(Routes::_gi()->_depth(4));

                        $obj_ditlibmas->_init($_REQUEST);

                        CDitlibmas::_gi()->_update($obj_ditlibmas);

                        Util::_redirect(
                            Util::_a_o(Util::o_ditlibmas . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;

                }
                break;

            case Util::o_mandiri:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $obj_mandiri = new MMandiri();
                        $obj_mandiri->_init($_REQUEST);
                        CMandiri::_gi()->_insert($obj_mandiri);

                        unset($_REQUEST['mandiri_id']);

                        $obj = CMandiri::_gi()->_gets($_REQUEST);

                        foreach ($obj as $item) {
                            CNonpeneliti::_gi()->update_nonpeneliti($item->getMandiriId(), $item->getMandiriFakultas(), Util::o_mandiri);
                            CPeneliti::_gi()->update_peneliti($item->getMandiriId(), $item->getMandiriFakultas(), Util::o_mandiri);
                        }

                        Util::_redirect(
                            Util::_a_o(Util::o_mandiri . DS . Util::status_success . DS . Util::action_add)
                        );
                        break;

                    case Util::action_edit:
                        $obj_mandiri = CMandiri::_gi()->_get(Routes::_gi()->_depth(4));
                        $obj_mandiri->_init($_REQUEST);

                        CMandiri::_gi()->_update($obj_mandiri);
                        Util::_redirect(
                            Util::_a_o(Util::o_mandiri . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::o_jurnal:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_jurnal = new MJurnal();
                        $obj_jurnal->_init($_REQUEST);

                        $berkas = $_FILES['jurnal_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'jurnal',
                                array(Files::type_documents), $obj_jurnal->getJurnalId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_jurnal->setJurnalFile($obj_file->get_file_uri_path());

                            CJurnal::_gi()->_insert($obj_jurnal);

                            unset($_REQUEST['jurnal_id']);

                            $obj = CJurnal::_gi()->_gets($_REQUEST);

                            foreach ($obj as $item) {
                                CPeneliti::_gi()->update_peneliti($item->getJurnalId(), $item->getJurnalFakultas(), Util::o_jurnal);
                                CNonpeneliti::_gi()->update_nonpeneliti($item->getJurnalId(), $item->getJurnalFakultas(), Util::o_jurnal);
                            }

                            Util::_redirect(
                                Util::_a_o(Util::o_jurnal . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_jurnal . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }

                        break;

                    case Util::action_edit:
                        $obj_jurnal = CJurnal::_gi()->_get(Routes::_gi()->_depth(4));
                        $filename = $obj_jurnal->getJurnalFile();

                        $obj_jurnal->_init($_REQUEST);

                        $berkas = $_FILES['jurnal_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'jurnal',
                                array(Files::type_documents), $obj_jurnal->getJurnalId());

                            $obj_file = $berkas_data['obj_file'];

                            $obj_jurnal->setJurnalFile($obj_file->get_file_uri_path());
                            CJurnal::_gi()->_update($obj_jurnal);

                        } else {
                            $obj_jurnal->setJurnalFile($filename);
                            CJurnal::_gi()->_update($obj_jurnal);
                        }

                        Util::_redirect(
                            Util::_a_o(Util::o_jurnal . DS . Util::status_success . DS . Util::action_edit)
                        );

                        break;
                }
                break;

            case Util::o_buku:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_buku = new MBuku();
                        $obj_buku->_init($_REQUEST);

                        $berkas = $_FILES['buku_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'buku',
                                array(Files::type_documents), $obj_buku->getBukuId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_buku->setBukuFile($obj_file->get_file_uri_path());

                            CBuku::_gi()->_insert($obj_buku);

                            Util::_redirect(
                                Util::_a_o(Util::o_buku . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_buku . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_buku = CBuku::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_buku->getBukuFile();

                        $obj_buku->_init($_REQUEST);

                        $berkas = $_FILES['buku_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'buku',
                                array(Files::type_documents), $obj_buku->getBukuId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_buku->setBukuFile($obj_file->get_file_uri_path());

                            CBuku::_gi()->_update($obj_buku);
                        } else {
                            $obj_buku->setBukuFile($filename);
                            CBuku::_gi()->_update($obj_buku);
                        }

                        Util::_redirect(
                            Util::_a_o(Util::o_buku . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::o_pemakalah:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_pemakalah = new MPemakalah();
                        $obj_pemakalah->_init($_REQUEST);

                        $berkas = $_FILES['pemakalah_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'pemakalah',
                                array(Files::type_documents), $obj_pemakalah->getPemakalahId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_pemakalah->setPemakalahFile($obj_file->get_file_uri_path());

                            CPemakalah::_gi()->_insert($obj_pemakalah);

                            Util::_redirect(
                                Util::_a_o(Util::o_pemakalah . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_pemakalah . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_pemakalah = CPemakalah::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_pemakalah->getPemakalahFile();

                        $obj_pemakalah->_init($_REQUEST);

                        $berkas = $_FILES['pemakalah_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'pemakalah',
                                array(Files::type_documents), $obj_pemakalah->getPemakalahId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_pemakalah->setPemakalahFile($obj_file->get_file_uri_path());

                            CPemakalah::_gi()->_update($obj_pemakalah);

                        } else {
                            $obj_pemakalah->setPemakalahFile($filename);

                            CPemakalah::_gi()->_update($obj_pemakalah);
                        }
                        Util::_redirect(
                            Util::_a_o(Util::o_pemakalah . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::o_hki:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_hki = new MHki();
                        $obj_hki->_init($_REQUEST);

                        $berkas = $_FILES['hki_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'hki',
                                array(Files::type_documents), $obj_hki->getHkiId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_hki->setHkiFile($obj_file->get_file_uri_path());

                            CHki::_gi()->_insert($obj_hki);

                            Util::_redirect(
                                Util::_a_o(Util::o_hki . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_hki . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_hki = CHki::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_hki->getHkiFile();

                        $obj_hki->_init($_REQUEST);

                        $berkas = $_FILES['hki_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'hki',
                                array(Files::type_documents), $obj_hki->getHkiId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_hki->setHkiFile($obj_file->get_file_uri_path());

                            CHki::_gi()->_update($obj_hki);
                        } else {
                            $obj_hki->setHkiFile($filename);
                            CHki::_gi()->_update($obj_hki);
                        }
                        Util::_redirect(
                            Util::_a_o(Util::o_hki . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;
            case Util::o_lain:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_lain = new MLain();
                        $obj_lain->_init($_REQUEST);

                        $berkas = $_FILES['lain_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'lain',
                                array(Files::type_documents), $obj_lain->getLainId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_lain->setLainFile($obj_file->get_file_uri_path());

                            CLain::_gi()->_insert($obj_lain);

                            Util::_redirect(
                                Util::_a_o(Util::o_lain . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_lain . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_lain = CLain::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_lain->getLainFile();

                        $obj_lain->_init($_REQUEST);

                        $berkas = $_FILES['lain_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'lain',
                                array(Files::type_documents), $obj_lain->getLainId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_lain->setLainFile($obj_file->get_file_uri_path());

                            CLain::_gi()->_update($obj_lain);

                        } else {
                            $obj_lain->setLainFile($filename);
                            CLain::_gi()->_update($obj_lain);
                        }

                        Util::_redirect(
                            Util::_a_o(Util::o_lain . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::o_fasilitas:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_fasilitas = new MFasilitas();
                        $obj_fasilitas->_init($_REQUEST);

                        $berkas = $_FILES['fasilitas_file'];

                        $foto_data = Files::_gi()->saveDO($berkas, 'fasilitas',
                            array(Files::type_documents),
                            $obj_fasilitas->getFasilitasId());

                        $obj_file = $foto_data['obj_file'];
                        $obj_fasilitas->setFasilitasFile($obj_file->get_file_uri_path());

                        CFasilitas::_gi()->_insert($obj_fasilitas);

                        unset($_REQUEST['fasilitas_id']);

                        $obj = CFasilitas::_gi()->_gets($_REQUEST);

                        Util::_redirect(
                            Util::_a_o(Util::o_fasilitas . DS . Util::status_success . DS . Util::action_add)
                        );
                        break;

                    case Util::action_edit:
                        $obj_fasilitas = CFasilitas::_gi()->_get(Routes::_gi()->_depth(4));

                        $obj_fasilitas->_init($_REQUEST);

                        $berkas = $_FILES['fasilitas_file'];
                        if ($berkas) {
                            $foto_data = Files::_gi()->saveDO($berkas, 'fasilitas',
                                array(Files::type_documents),
                                $obj_fasilitas->getFasilitasId());

                            $obj_file = $foto_data['obj_file'];
                            $filename = $obj_file->get_file_uri_path();
                        } else {
                            $filename = $obj_fasilitas->getFasilitasFile();
                        }

                        $obj_fasilitas->setFasilitasFile($filename);

                        CFasilitas::_gi()->_update($obj_fasilitas);
                        Util::_redirect(
                            Util::_a_o(Util::o_fasilitas . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;
            case Util::o_forum:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_forum = new MForum();
                        $obj_forum->_init($_REQUEST);

                        CForum::_gi()->_insert($obj_forum);

                        unset($_REQUEST['forum_id']);

                        $obj = CForum::_gi()->_gets($_REQUEST);

                        Util::_redirect(
                            Util::_a_o(Util::o_forum . DS . Util::status_success . DS . Util::action_add)
                        );
                        break;

                    case Util::action_edit:
                        $obj_forum = CForum::_gi()->_get(Routes::_gi()->_depth(4));

                        $obj_forum->_init($_REQUEST);

                        CForum::_gi()->_update($obj_forum);
                        Util::_redirect(
                            Util::_a_o(Util::o_forum . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;
            case Util::o_kontrak:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_kontrak = new MKontrak();
                        $obj_kontrak->_init($_REQUEST);

                        $berkas = $_FILES['kontrak_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'kontrak',
                                array(Files::type_documents), $obj_kontrak->getKontrakId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_kontrak->setKontrakFile($obj_file->get_file_uri_path());

                            CKontrak::_gi()->_insert($obj_kontrak);

                            Util::_redirect(
                                Util::_a_o(Util::o_kontrak . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_kontrak . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_kontrak = CKontrak::_gi()->_get(Routes::_gi()->_depth(4));

                        $obj_kontrak->_init($_REQUEST);

                        $berkas = $_FILES['kontrak_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'kontrak',
                                array(Files::type_documents), $obj_kontrak->getKontrakId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_kontrak->setKontrakFile($obj_file->get_file_uri_path());

                            CKontrak::_gi()->_update($obj_kontrak);

                            Util::_redirect(
                                Util::_a_o(Util::o_kontrak . DS . Util::status_success . DS . Util::action_edit)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_kontrak . DS . Util::status_failed . DS . Util::action_edit)
                            );
                        }
                        break;
                }
                break;
            case Util::o_bisnis:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_bisnis = new MBisnis();
                        $obj_bisnis->_init($_REQUEST);

                        $berkas = $_FILES['bisnis_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'bisnis',
                                array(Files::type_documents), $obj_bisnis->getBisnisId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_bisnis->setBisnisFile($obj_file->get_file_uri_path());

                            CBisnis::_gi()->_insert($obj_bisnis);

                            Util::_redirect(
                                Util::_a_o(Util::o_bisnis . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o(Util::o_bisnis . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_bisnis = CBisnis::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_bisnis->getBisnisFile();

                        $obj_bisnis->_init($_REQUEST);

                        $berkas = $_FILES['bisnis_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'bisnis',
                                array(Files::type_documents), $obj_bisnis->getBisnisId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_bisnis->setBisnisFile($obj_file->get_file_uri_path());

                            CBisnis::_gi()->_update($obj_bisnis);

                        } else {
                            $obj_bisnis->setBisnisFile($filename);
                            CBisnis::_gi()->_update($obj_bisnis);
                        }

                        Util::_redirect(
                            Util::_a_o(Util::o_bisnis . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;
            case Util::o_peneliti:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $id_s = Routes::_gi()->_depth(4);
                        $tabel = Routes::_gi()->_depth(5);
//                        var_dump($tabel);
                        $obj_peneliti = new MPeneliti();
                        $obj_peneliti->_init($_REQUEST);
                        CPeneliti::_gi()->_insert($obj_peneliti);

                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . Util::status_success . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_delete:
                        $id = Routes::_gi()->_depth(4);
                        $id_s = Routes::_gi()->_depth(5);
                        $tabel = Routes::_gi()->_depth(6);

                        $suc = CPeneliti::_gi()->_delete($id);
                        if ($suc) {
                            $status = Util::status_success;
                        } else {
                            $status = Util::status_failed;
                        }

                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . $status . DS . Util::action_delete)
                            );
                        }
                        break;
                }

                break;

            case Util::o_nonpeneliti:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $id_s = Routes::_gi()->_depth(4);
                        $tabel = Routes::_gi()->_depth(5);
                        $obj_nonpeneliti = new MNonpeneliti();
                        $obj_nonpeneliti->_init($_REQUEST);
                        CNonpeneliti::_gi()->_insert($obj_nonpeneliti);

                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . Util::status_success . DS . Util::action_add)
                            );
                        }
                        break;
                    case Util::action_delete:
                        $id = Routes::_gi()->_depth(4);
                        $id_s = Routes::_gi()->_depth(5);
                        $tabel = Routes::_gi()->_depth(6);

                        $suc = CNonpeneliti::_gi()->_delete($id);
                        if ($suc) {
                            $status = Util::status_success;
                        } else {
                            $status = Util::status_failed;
                        }

                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_o($tabel . DS . $status . DS . Util::action_delete)
                            );
                        }
                        break;
                }
                break;

                break;

            case Util::page_d:

//        if (!Sessions::_gi()->_logged_in())
//            Util::_redirect();

        }
        break;


    case Util::page_d:

        switch (Routes::_gi()->_depth(2)) {
            case Util::d_ditlibmas:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $obj_ditlibmas = new MDitlibmas();
                        $obj_ditlibmas->_init($_REQUEST);

                        CDitlibmas::_gi()->_insert($obj_ditlibmas);

                        unset($_REQUEST['ditlibmas_id']);

                        $obj = CDitlibmas::_gi()->_gets($_REQUEST);

                        foreach ($obj as $item) {
                            CPeneliti::_gi()->update_peneliti($item->getDitlibmasId(), $item->getDitlibmasFakultas(), Util::d_ditlibmas);
                            CNonpeneliti::_gi()->update_nonpeneliti($item->getDitlibmasId(), $item->getDitlibmasFakultas(), Util::d_ditlibmas);
                        }

                        Util::_redirect(
                            Util::_a_d(Util::d_ditlibmas . DS . Util::status_success . DS . Util::action_add)
                        );

                        break;

                    case Util::action_edit:
                        $obj_ditlibmas = CDitlibmas::_gi()->_get(Routes::_gi()->_depth(4));

                        $obj_ditlibmas->_init($_REQUEST);

                        CDitlibmas::_gi()->_update($obj_ditlibmas);

                        Util::_redirect(
                            Util::_a_d(Util::d_ditlibmas . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;

                }
                break;
            case Util::d_mandiri:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $obj_mandiri = new MMandiri();
                        $obj_mandiri->_init($_REQUEST);
                        CMandiri::_gi()->_insert($obj_mandiri);

                        unset($_REQUEST['mandiri_id']);

                        $obj = CMandiri::_gi()->_gets($_REQUEST);

                        foreach ($obj as $item) {
                            CNonpeneliti::_gi()->update_nonpeneliti($item->getMandiriId(), $item->getMandiriFakultas(), Util::d_mandiri);
                            CPeneliti::_gi()->update_peneliti($item->getMandiriId(), $item->getMandiriFakultas(), Util::d_mandiri);
                        }

                        Util::_redirect(
                            Util::_a_d(Util::d_mandiri . DS . Util::status_success . DS . Util::action_add)
                        );
                        break;

                    case Util::action_edit:
//
                        $obj_mandiri = CMandiri::_gi()->_get(Routes::_gi()->_depth(4));
                        $obj_mandiri->_init($_REQUEST);

                        CMandiri::_gi()->_update($obj_mandiri);
                        Util::_redirect(
                            Util::_a_d(Util::d_mandiri . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::d_jurnal:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_jurnal = new MJurnal();
                        $obj_jurnal->_init($_REQUEST);

                        $berkas = $_FILES['jurnal_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'jurnal',
                                array(Files::type_documents), $obj_jurnal->getJurnalId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_jurnal->setJurnalFile($obj_file->get_file_uri_path());

                            CJurnal::_gi()->_insert($obj_jurnal);

                            unset($_REQUEST['jurnal_id']);

                            $obj = CJurnal::_gi()->_gets($_REQUEST);

                            foreach ($obj as $item) {
                                CPeneliti::_gi()->update_peneliti($item->getJurnalId(), $item->getJurnalFakultas(), Util::d_jurnal);
                                CNonpeneliti::_gi()->update_nonpeneliti($item->getJurnalId(), $item->getJurnalFakultas(), Util::d_jurnal);
                            }

                            Util::_redirect(
                                Util::_a_d(Util::d_jurnal . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d(Util::d_jurnal . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }

                        break;

                    case Util::action_edit:
                        $obj_jurnal = CJurnal::_gi()->_get(Routes::_gi()->_depth(4));
                        $filename = $obj_jurnal->getJurnalFile();

                        $obj_jurnal->_init($_REQUEST);

                        $berkas = $_FILES['jurnal_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'jurnal',
                                array(Files::type_documents), $obj_jurnal->getJurnalId());

                            $obj_file = $berkas_data['obj_file'];

                            $obj_jurnal->setJurnalFile($obj_file->get_file_uri_path());
                            CJurnal::_gi()->_update($obj_jurnal);

                        } else {
                            $obj_jurnal->setJurnalFile($filename);
                            CJurnal::_gi()->_update($obj_jurnal);
                        }

                        Util::_redirect(
                            Util::_a_d(Util::d_jurnal . DS . Util::status_success . DS . Util::action_edit)
                        );

                        break;
                }
                break;

            case Util::d_buku:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_buku = new MBuku();
                        $obj_buku->_init($_REQUEST);

                        $berkas = $_FILES['buku_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'buku',
                                array(Files::type_documents), $obj_buku->getBukuId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_buku->setBukuFile($obj_file->get_file_uri_path());

                            CBuku::_gi()->_insert($obj_buku);

                            Util::_redirect(
                                Util::_a_d(Util::d_buku . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d(Util::d_buku . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_buku = CBuku::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_buku->getBukuFile();

                        $obj_buku->_init($_REQUEST);

                        $berkas = $_FILES['buku_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'buku',
                                array(Files::type_documents), $obj_buku->getBukuId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_buku->setBukuFile($obj_file->get_file_uri_path());

                            CBuku::_gi()->_update($obj_buku);
                        } else {
                            $obj_buku->setBukuFile($filename);
                            CBuku::_gi()->_update($obj_buku);
                        }

                        Util::_redirect(
                            Util::_a_d(Util::d_buku . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::d_pemakalah:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_pemakalah = new MPemakalah();
                        $obj_pemakalah->_init($_REQUEST);

                        $berkas = $_FILES['pemakalah_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'pemakalah',
                                array(Files::type_documents), $obj_pemakalah->getPemakalahId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_pemakalah->setPemakalahFile($obj_file->get_file_uri_path());

                            CPemakalah::_gi()->_insert($obj_pemakalah);

                            Util::_redirect(
                                Util::_a_d(Util::d_pemakalah . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d(Util::d_pemakalah . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_pemakalah = CPemakalah::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_pemakalah->getPemakalahFile();

                        $obj_pemakalah->_init($_REQUEST);

                        $berkas = $_FILES['pemakalah_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'pemakalah',
                                array(Files::type_documents), $obj_pemakalah->getPemakalahId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_pemakalah->setPemakalahFile($obj_file->get_file_uri_path());

                            CPemakalah::_gi()->_update($obj_pemakalah);

                        } else {
                            $obj_pemakalah->setPemakalahFile($filename);

                            CPemakalah::_gi()->_update($obj_pemakalah);
                        }
                        Util::_redirect(
                            Util::_a_d(Util::d_pemakalah . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::d_hki:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_hki = new MHki();
                        $obj_hki->_init($_REQUEST);

                        $berkas = $_FILES['hki_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'hki',
                                array(Files::type_documents), $obj_hki->getHkiId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_hki->setHkiFile($obj_file->get_file_uri_path());

                            CHki::_gi()->_insert($obj_hki);

                            Util::_redirect(
                                Util::_a_d(Util::d_hki . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d(Util::d_hki . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_hki = CHki::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_hki->getHkiFile();

                        $obj_hki->_init($_REQUEST);

                        $berkas = $_FILES['hki_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'hki',
                                array(Files::type_documents), $obj_hki->getHkiId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_hki->setHkiFile($obj_file->get_file_uri_path());

                            CHki::_gi()->_update($obj_hki);
                        } else {
                            $obj_hki->setHkiFile($filename);
                            CHki::_gi()->_update($obj_hki);
                        }
                        Util::_redirect(
                            Util::_a_d(Util::d_hki . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;
            case Util::d_lain:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $obj_lain = new MLain();
                        $obj_lain->_init($_REQUEST);

                        $berkas = $_FILES['lain_file'];

                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'lain',
                                array(Files::type_documents), $obj_lain->getLainId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_lain->setLainFile($obj_file->get_file_uri_path());

                            CLain::_gi()->_insert($obj_lain);

                            Util::_redirect(
                                Util::_a_d(Util::d_lain . DS . Util::status_success . DS . Util::action_add)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d(Util::d_lain . DS . Util::status_failed . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_edit:
                        $obj_lain = CLain::_gi()->_get(Routes::_gi()->_depth(4));

                        $filename = $obj_lain->getLainFile();

                        $obj_lain->_init($_REQUEST);

                        $berkas = $_FILES['lain_file'];
                        if ($berkas['error'] == 0) {
                            $berkas_data = Files::_gi()->saveDO($berkas, 'lain',
                                array(Files::type_documents), $obj_lain->getLainId());

                            $obj_file = $berkas_data['obj_file'];
                            $obj_lain->setLainFile($obj_file->get_file_uri_path());

                            CLain::_gi()->_update($obj_lain);

                        } else {
                            $obj_lain->setLainFile($filename);
                            CLain::_gi()->_update($obj_lain);
                        }

                        Util::_redirect(
                            Util::_a_d(Util::d_lain . DS . Util::status_success . DS . Util::action_edit)
                        );
                        break;
                }
                break;

            case Util::d_peneliti:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:

                        $id_s = Routes::_gi()->_depth(4);
                        $tabel = Routes::_gi()->_depth(5);

                        $obj_peneliti = new MPeneliti();
                        $obj_peneliti->_init($_REQUEST);
                        CPeneliti::_gi()->_insert($obj_peneliti);


                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . Util::status_success . DS . Util::action_add)
                            );
                        }
                        break;

                    case Util::action_delete:
                        $id = Routes::_gi()->_depth(4);
                        $id_s = Routes::_gi()->_depth(5);
                        $tabel = Routes::_gi()->_depth(6);

                        $suc = CPeneliti::_gi()->_delete($id);
                        if ($suc) {
                            $status = Util::status_success;
                        } else {
                            $status = Util::status_failed;
                        }


                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . $status . DS . Util::action_delete)
                            );
                        }
                        break;
                }

                break;

            case Util::d_nonpeneliti:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_add:
                        $id_s = Routes::_gi()->_depth(4);
                        $tabel = Routes::_gi()->_depth(5);
                        $obj_nonpeneliti = new MNonpeneliti();
                        $obj_nonpeneliti->_init($_REQUEST);
                        CNonpeneliti::_gi()->_insert($obj_nonpeneliti);

                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . Util::status_success . DS . Util::action_add)
                            );
                        }
                        break;
                    case Util::action_delete:
                        $id = Routes::_gi()->_depth(4);
                        $id_s = Routes::_gi()->_depth(5);
                        $tabel = Routes::_gi()->_depth(6);

                        $suc = CNonpeneliti::_gi()->_delete($id);
                        if ($suc) {
                            $status = Util::status_success;
                        } else {
                            $status = Util::status_failed;
                        }

                        if ($id_s != 0) {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . Util::action_edit . DS . $id_s)
                            );
                        } else {
                            Util::_redirect(
                                Util::_a_d($tabel . DS . $status . DS . Util::action_delete)
                            );
                        }
                }

        }
        break;



    case Util::page_v:

        switch (Routes::_gi()->_depth(2)) {

            case Util::v_jurnal:
                switch (Routes::_gi()->_depth(3)) {
                    case Util::action_verify:


                        $obj_jurnal = CJurnal::_gi()->_get($_REQUEST['jurnal_id']);
                        $obj_jurnal->_init($_REQUEST);

                        CJurnal::_gi()->_update($obj_jurnal);
                        Util::_redirect(
                            Util::_a_v(Util::v_jurnal . DS . Util::status_success . DS . Util::action_edit)
                        );

                        break;


                }
                break;

        }
        break;
}