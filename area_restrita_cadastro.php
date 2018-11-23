<?php 
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
require 'processos/load_imoveis.php';
?>
<!Doctype html>
<html>
<head>
    <title> Área Restrita </title>
    <link rel="Stylesheet" href="css/bootstrap.min.css">
    <link rel="Stylesheet" href="css/style_restricted_area.css">
    <link rel="Stylesheet" href="css/included_styles.css">
    <meta charset="utf-8">
</head>
<body>
    <div id="loading" style="position: absolute; top: 0; left: 0; display: none; width: 100%; height: 100%; z-index: 1000; background: rgba(0, 0, 0, 0.6);">
        <div style="background: white; width: 25%; position: absolute; left: 37.5%; top: 10em; padding: 2em; text-align: center">
            Aguarde...
        </div>
    </div>
    <!--Top bar-->   
	<?php include '_includes/menu.php'; ?>

    <!-- Início da área da tabela -->
    <section class="section-table">
        <div class="row">
            <div class="col-sm-3 text-center pt-2">Bem-vinda, Danila!</div>
            <div class="button col-sm-3 offset-md-6 text-center">
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modalcadastro">+Adicionar Imóvel</button>
            </div>
        </div>

        <div class="row justify-content-center mt-4" id="tabela">
            <div class="col-sm-11 table1">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"  style="width: 20%">Destaque</th>
                            <th scope="col">Código</th>
                            <th scope="col" style="width: 25%">Título</th>
                            <th scope="col" style="width: 12%;">Tipo</th>
                            <th scope="col" style="width: 15%;">Categoria</th>
                            <th scope="col" style="width: 12%">Situação</th>
                            <th scope="col" style="width: 20%"></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($imoveis)): ?>
                            <?php foreach($imoveis as $imovel): ?>
                            <?php
                            $status = null;
                            switch ($imovel['IMO_SITUACAO']) {
                                case 1:
                                    $status = 'Vigente';
                                    break;
                                case 2:
                                    $status = 'Em negociação';
                                    break;
                                case 3:
                                    $status = 'Alugado';
                                    break;
                                case 4:
                                    $status = 'Vendido';
                                    break;
                            }
                            ?>
                            <tr>
                                <th scope="row"><input type="checkbox" class="checkboxDestaque" onclick="setDestaque('<?=$imovel['IMO_COD']?>', this.checked);" <?=$imovel['IMO_DESTAQUE'] ? 'checked' : ''?>></th>
                                <td><?=$imovel['IMO_COD']?></td>
                                <td><?=$imovel['IMO_NOME']?></td>
                                <td><?=$imovel['IMO_TIPO']?></td>
                                <td><?=$imovel['IMO_CATEGORIA']?></td>
                                <td><?=$status?> </td>
                                <td> <button type="submit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modaleditar" onclick="document.getElementById('targetCod').value = '<?=$imovel['IMO_COD']?>'">Editar</button>
                                <button type="submit" class="btn btn-primary btn-sm" action="">Remover</button> <td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                        <tr>
                            <th>Não há imóveis cadastrados</th>
                        </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!--Fim da área da tabela-->


    <!--MODAL DE CADASTRO-->
    <div class="modal fade bd-example-modal-lg" id="modalcadastro" tabindex="0" role="dialog" aria-labelledby="modalcadastro"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcadastro">Cadastro de Imóveis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="cadastro_imovel" method="POST" action="processos/cadastrar.php" enctype="multipart/form-data">
                        <input type="text" id="#" class="form-control" name="nome" placeholder="Título" size="50" required>

                        <div class="row justify-content-center">
                            <select name="tipo" id="#" class="form-control form-control-md mt-3 mr-5" style="width: 20%; float: left;" required>
                                <option value="" selected disabled> Tipo </option>
                                <option value="Casa">Casa</option>
                                <option value="Apartamento">Apartamento</option>
                                <option value="Barracao">Barracão</option>
                                <option value="Comercial">Comercial</option>
                                <option value="KitNet">Kitnet</option>
                            </select>

                            <select name="categoria" id="#" class="form-control form-control-md mt-3 mr-5" style="width: 20%; float: left;" required>
                                <option value="" selected disabled> Categoria </option>
                                <option value="Comprar">Comprar</option>
                                <option value="Alugar">Alugar</option>
                                <option value="Lancamentos">Lançamentos</option>
                                <option value="Rural">Rural</option>
                            </select>
                            <input type="text" class="form-control mt-3" placeholder="Bairro" style="width: 20%;" name="bairro" id="#" required>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Dormitórios </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="suites" placeholder="Suítes" style="width: 120%;" required> 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="quartos" placeholder="Quartos" style="width: 120%;" required> 
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Área </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="area_total" placeholder="Total" style="width: 120%;" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="area_construida" placeholder="Construída" style="width:150%;" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Outros </h6>
                                <div class="row justify-content-center P-0">
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="banheiros" placeholder="WC" style="width: 120%;" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="vagas" placeholder="Vagas" style="width:120%;" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-8 text-center">
                                <h6 class=""> Condomínio? </h6>
                                <div class="row justify-content-center P-0" style="margin-left: -30%;">
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="radio" id="#" name="condominio" value="1"> Sim 
                                    </div>
                                    <div class="col-sm-4" style="margin-left: -6%;">
                                        <input class="form-control" type="text" id="#" name="endereco_condominio" placeholder="Condomínio" style="width: 180%;"> 
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="radio" id="#" name="condominio" value="0" style="margin-left: 95%;" checked> <span style="margin-left: 200%">Não</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-8 text-center">
                                <h6 class=""> Características </h6>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
                                        <input type="text" class="form-control" id="#" name="cad[1]" placeholder="Característica 1" required> 
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[6]" placeholder="Característica 6" required>

                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
                                        <input type="text" class="form-control" id="#" name="cad[2]" placeholder="Característica 2" required> 
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[7]" placeholder="Característica 7" required>
                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%; ">
                                    <div class="col-sm-4 offset-md-2">
                                        <input type="text" class="form-control" id="#" name="cad[3]" placeholder="Característica 3"> 
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[8]" placeholder="Característica 8">
                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
                                        <input type="text" class="form-control" id="#" name="cad[4]" placeholder="Característica 4"> 
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[9]" placeholder="Característica 9">
                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
                                        <input type="text" class="form-control" id="#" name="cad[5]" placeholder="Característica 5"> 
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[10]" placeholder="Característica 10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row text-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Preços </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="preco_aluguel" placeholder="Aluguel" style="width: 120%;" required> 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="preco_venda" placeholder="Venda" style="width: 120%;" required> 
                                    </div>    
                                </div>
                            </div>

                            <div class="col-sm-6 text-center">
                                <h6 class=""> Reformas </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6"> 
                                        <input type="text" class="form-control" id="#" name="reformas" placeholder="Qtd Reformas" style="width: 120%;" required> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Situação </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6"> 
                                        <input type="text" class="form-control" id="#" name="situacao" placeholder="Situação" style="width: 120%;" required> 
                                    </div>    
                                </div>
                            </div>

                            <div class="col-sm-6 text-center">
                                <h6 class=""> Destaque? </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="destaque" value="1"> Sim 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="destaque" value="2"> Não 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                           <div class="col-sm-12 text-center">
                                <h6 class=""> Ativo? </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="ativo" value="1"> Sim 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="ativo" value="2"> Não 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                          

                        <div class="row justify-content-center">
                            <div class="col-sm-8 mt-3">
                                <textarea class="form-control" name="descricao" required> Descrição </textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3 offset-md-2">
                            <div class="col-sm-4 mt-3 pl-5">
                                <h6  style="margin-left: 14%;">Enviar Imagem</h6>
                            <div class="col-sm-8 mt-3 pl-3">
                                <input type="file" name="foto0" id="#" class="#"  accept="image/png, image/jpeg" multiple required> 
                                <input type="hidden" name="MAX_FILE_SIZE" value="122500"/>      
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm-12 mt-3 text-center">
                                <button type="submit" class="btn btn-primary" id="#" name="">Cadastrar Imóvel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL DE ALTERAR **NÃO FINALIZADO**-->
    <div class="modal fade bd-example-modal-lg" id="modaleditar" tabindex="0" role="dialog" aria-labelledby="modalcadastro"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcadastro">Cadastro de Imóveis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
<<<<<<< HEAD
                    <form name="cadastro_imovel" method="POST" action="processos/cadastrar.php" enctype="multipart/form-data">
                        <input type="text" id="#" class="form-control" name="nome" placeholder="Título" size="50" required>
=======
                <form name="cadastro_imovel" method="POST" action="processos/change_imoveis.php">
                            <input type="text" id="#" class="form-control" name="nome" placeholder="Título" size="50"
                            required>
                        <input type="hidden" name="cod" id="targetCod">

                        <div class="row justify-content-center">
>>>>>>> bee73a3364174ce646833d2e97532be7917e6a1f

                        <div class="row justify-content-center">
                            <select name="tipo" id="#" class="form-control form-control-md mt-3 mr-5" style="width: 20%; float: left;" required>
                                <option value="" selected disabled> Tipo </option>
                                <option value="Casa">Casa</option>
                                <option value="Apartamento">Apartamento</option>
                                <option value="Barracao">Barracão</option>
                                <option value="Comercial">Comercial</option>
                                <option value="KitNet">Kitnet</option>
                            </select>

                            <select name="categoria" id="#" class="form-control form-control-md mt-3 mr-5" style="width: 20%; float: left;" required>
                                <option value="" selected disabled> Categoria </option>
                                <option value="Comprar">Comprar</option>
                                <option value="Alugar">Alugar</option>
                                <option value="Lancamentos">Lançamentos</option>
                                <option value="Rural">Rural</option>
                            </select>
                            <input type="text" class="form-control mt-3" placeholder="Bairro" style="width: 20%;" name="bairro" id="#" required>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Dormitórios </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="suites" placeholder="Suítes" style="width: 120%;" required> 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="quartos" placeholder="Quartos" style="width: 120%;" required> 
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Área </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="area_total" placeholder="Total" style="width: 120%;" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="area_construida" placeholder="Construída" style="width:150%;" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Outros </h6>
                                <div class="row justify-content-center P-0">
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="banheiros" placeholder="WC" style="width: 120%;" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="#" name="vagas" placeholder="Vagas" style="width:120%;" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-8 text-center">
                                <h6 class=""> Condomínio? </h6>
                                <div class="row justify-content-center P-0" style="margin-left: -30%;">
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="radio" id="#" name="condominio" value="1"> Sim 
                                    </div>
                                    <div class="col-sm-4" style="margin-left: -6%;">
                                        <input class="form-control" type="text" id="#" name="endereco_condominio" placeholder="Condomínio" style="width: 180%;"> 
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="radio" id="#" name="condominio" value="0" style="margin-left: 95%;" checked> <span style="margin-left: 200%">Não</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-sm-8 text-center">
                                <h6 class=""> Características </h6>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
<<<<<<< HEAD
                                        <input type="text" class="form-control" id="#" name="cad[1]" placeholder="Característica 1" required> 
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[6]" placeholder="Característica 6" required>

=======
                                        <input type="text" class="form-control" id="#" name="cad[1]" placeholder="Característica 1" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[6]" placeholder="Característica 6" required>
>>>>>>> bee73a3364174ce646833d2e97532be7917e6a1f
                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
<<<<<<< HEAD
                                        <input type="text" class="form-control" id="#" name="cad[2]" placeholder="Característica 2" required> 
=======
                                        <input type="text" class="form-control" id="#" name="cad[2]" placeholder="Característica 2" required>
>>>>>>> bee73a3364174ce646833d2e97532be7917e6a1f
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[7]" placeholder="Característica 7" required>
                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%; ">
                                    <div class="col-sm-4 offset-md-2">
<<<<<<< HEAD
                                        <input type="text" class="form-control" id="#" name="cad[3]" placeholder="Característica 3"> 
=======
                                        <input type="text" class="form-control" id="#" name="cad[3]" placeholder="Característica 3">
>>>>>>> bee73a3364174ce646833d2e97532be7917e6a1f
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[8]" placeholder="Característica 8">
                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
<<<<<<< HEAD
                                        <input type="text" class="form-control" id="#" name="cad[4]" placeholder="Característica 4"> 
=======
                                        <input type="text" class="form-control" id="#" name="cad[4]" placeholder="Característica 4">
>>>>>>> bee73a3364174ce646833d2e97532be7917e6a1f
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[9]" placeholder="Característica 9">
                                    </div>
                                </div>
                                <div class="row justify-content-center P-0" style="margin-left: -23%; margin-bottom: 3%;">
                                    <div class="col-sm-4 offset-md-2">
<<<<<<< HEAD
                                        <input type="text" class="form-control" id="#" name="cad[5]" placeholder="Característica 5"> 
=======
                                        <input type="text" class="form-control" id="#" name="cad[5]" placeholder="Característica 5">
>>>>>>> bee73a3364174ce646833d2e97532be7917e6a1f
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="#" name="cad[10]" placeholder="Característica 10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row text-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Preços </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="preco_aluguel" placeholder="Aluguel" style="width: 120%;" required> 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" id="#" name="preco_venda" placeholder="Venda" style="width: 120%;" required> 
                                    </div>    
                                </div>
                            </div>

                            <div class="col-sm-6 text-center">
                                <h6 class=""> Reformas </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6"> 
                                        <input type="text" class="form-control" id="#" name="reformas" placeholder="Qtd Reformas" style="width: 120%;" required> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col-sm-6 text-center">
                                <h6 class=""> Situação </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6"> 
                                        <input type="text" class="form-control" id="#" name="situacao" placeholder="Situação" style="width: 120%;" required> 
                                    </div>    
                                </div>
                            </div>

                            <div class="col-sm-6 text-center">
                                <h6 class=""> Destaque? </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="destaque" value="1"> Sim 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="destaque" value="2"> Não 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center mt-3">
                           <div class="col-sm-12 text-center">
                                <h6 class=""> Ativo? </h6>
                                <div class="row justify-content-center">
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="ativo" value="1"> Sim 
                                    </div>
                                    <div class="col-sm-3"> 
                                        <input class="form-check-input" type="radio" id="#" name="ativo" value="2"> Não 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                          

                        <div class="row justify-content-center">
                            <div class="col-sm-8 mt-3">
                                <textarea class="form-control" name="descricao" required> Descrição </textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3 offset-md-2">
                            <div class="col-sm-4 mt-3 pl-5">
                                <h6  style="margin-left: 14%;">Enviar Imagem</h6>
                            </div>
                            <div class="col-sm-8 mt-3 pl-3">
                                <input type="file" name="foto0" id="#" class="#"  accept="image/png, image/jpeg" multiple required> 
                                <input type="hidden" name="MAX_FILE_SIZE" value="122500"/>      
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm-12 mt-3 text-center">
<<<<<<< HEAD
                                <button type="submit" class="btn btn-primary" id="#" name="">Cadastrar Imóvel</button>
=======
                                <button type="submit" class="btn btn-primary" id="#" name=""> Alterar Imóvel </button>
>>>>>>> bee73a3364174ce646833d2e97532be7917e6a1f
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--Footer-->
    <?php include '_includes/footer.php'; ?>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
</body>
</head>
