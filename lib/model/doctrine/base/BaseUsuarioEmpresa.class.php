<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('UsuarioEmpresa', 'doctrine');

/**
 * BaseUsuarioEmpresa
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $usuario_id
 * @property integer $empresa_id
 * @property Empresa $Empresa
 * @property Usuario $Usuario
 * 
 * @method integer        getUsuarioId()  Returns the current record's "usuario_id" value
 * @method integer        getEmpresaId()  Returns the current record's "empresa_id" value
 * @method Empresa        getEmpresa()    Returns the current record's "Empresa" value
 * @method Usuario        getUsuario()    Returns the current record's "Usuario" value
 * @method UsuarioEmpresa setUsuarioId()  Sets the current record's "usuario_id" value
 * @method UsuarioEmpresa setEmpresaId()  Sets the current record's "empresa_id" value
 * @method UsuarioEmpresa setEmpresa()    Sets the current record's "Empresa" value
 * @method UsuarioEmpresa setUsuario()    Sets the current record's "Usuario" value
 * 
 * @package    Procine
 * @subpackage model
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseUsuarioEmpresa extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('usuario_empresa');
        $this->hasColumn('usuario_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('empresa_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Empresa', array(
             'local' => 'empresa_id',
             'foreign' => 'id'));

        $this->hasOne('Usuario', array(
             'local' => 'usuario_id',
             'foreign' => 'id'));
    }
}