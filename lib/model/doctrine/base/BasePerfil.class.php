<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Perfil', 'doctrine');

/**
 * BasePerfil
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $descricao
 * @property integer $nivel
 * @property integer $status
 * @property Doctrine_Collection $Usuarios
 * @property Doctrine_Collection $Processos
 * @property Doctrine_Collection $PerfilProcesso
 * @property Doctrine_Collection $UsuarioPerfil
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method string              getDescricao()      Returns the current record's "descricao" value
 * @method integer             getNivel()          Returns the current record's "nivel" value
 * @method integer             getStatus()         Returns the current record's "status" value
 * @method Doctrine_Collection getUsuarios()       Returns the current record's "Usuarios" collection
 * @method Doctrine_Collection getProcessos()      Returns the current record's "Processos" collection
 * @method Doctrine_Collection getPerfilProcesso() Returns the current record's "PerfilProcesso" collection
 * @method Doctrine_Collection getUsuarioPerfil()  Returns the current record's "UsuarioPerfil" collection
 * @method Perfil              setId()             Sets the current record's "id" value
 * @method Perfil              setDescricao()      Sets the current record's "descricao" value
 * @method Perfil              setNivel()          Sets the current record's "nivel" value
 * @method Perfil              setStatus()         Sets the current record's "status" value
 * @method Perfil              setUsuarios()       Sets the current record's "Usuarios" collection
 * @method Perfil              setProcessos()      Sets the current record's "Processos" collection
 * @method Perfil              setPerfilProcesso() Sets the current record's "PerfilProcesso" collection
 * @method Perfil              setUsuarioPerfil()  Sets the current record's "UsuarioPerfil" collection
 * 
 * @package    Procine
 * @subpackage model
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BasePerfil extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('perfil');
        $this->hasColumn('perfil_id as id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('perfil_nm_descricao as descricao', 'string', 50, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '50',
             ));
        $this->hasColumn('perfil_nu_nivel as nivel', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '1',
             ));
        $this->hasColumn('perfil_nu_status as status', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '1',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '1',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Usuario as Usuarios', array(
             'refClass' => 'UsuarioPerfil',
             'local' => 'perfil_id',
             'foreign' => 'usuario_id'));

        $this->hasMany('Processo as Processos', array(
             'refClass' => 'PerfilProcesso',
             'local' => 'perfil_id',
             'foreign' => 'processo_id'));

        $this->hasMany('PerfilProcesso', array(
             'local' => 'id',
             'foreign' => 'perfil_id'));

        $this->hasMany('UsuarioPerfil', array(
             'local' => 'id',
             'foreign' => 'perfil_id'));
    }
}