<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Empresa', 'doctrine');

/**
 * BaseEmpresa
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $razao_social
 * @property string $nome_fantasia
 * @property string $cnpj
 * @property integer $status
 * @property Doctrine_Collection $Usuarios
 * @property Doctrine_Collection $UsuarioEmpresa
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method string              getRazaoSocial()    Returns the current record's "razao_social" value
 * @method string              getNomeFantasia()   Returns the current record's "nome_fantasia" value
 * @method string              getCnpj()           Returns the current record's "cnpj" value
 * @method integer             getStatus()         Returns the current record's "status" value
 * @method Doctrine_Collection getUsuarios()       Returns the current record's "Usuarios" collection
 * @method Doctrine_Collection getUsuarioEmpresa() Returns the current record's "UsuarioEmpresa" collection
 * @method Empresa             setId()             Sets the current record's "id" value
 * @method Empresa             setRazaoSocial()    Sets the current record's "razao_social" value
 * @method Empresa             setNomeFantasia()   Sets the current record's "nome_fantasia" value
 * @method Empresa             setCnpj()           Sets the current record's "cnpj" value
 * @method Empresa             setStatus()         Sets the current record's "status" value
 * @method Empresa             setUsuarios()       Sets the current record's "Usuarios" collection
 * @method Empresa             setUsuarioEmpresa() Sets the current record's "UsuarioEmpresa" collection
 * 
 * @package    Procine
 * @subpackage model
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseEmpresa extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('empresa');
        $this->hasColumn('empresa_id as id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('empresa_nm_razaosocial as razao_social', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('empresa_nm_nomefantasia as nome_fantasia', 'string', 20, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '20',
             ));
        $this->hasColumn('empresa_nu_cnpj as cnpj', 'string', 14, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '14',
             ));
        $this->hasColumn('empresa_nu_status as status', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => '1',
             'length' => '1',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Usuario as Usuarios', array(
             'refClass' => 'UsuarioEmpresa',
             'local' => 'empresa_id',
             'foreign' => 'usuario_id'));

        $this->hasMany('UsuarioEmpresa', array(
             'local' => 'id',
             'foreign' => 'empresa_id'));
    }
}