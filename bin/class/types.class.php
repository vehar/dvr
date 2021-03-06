<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 27.03.14
 * Time: 2:48
 */

abstract class Type {

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        if($value instanceof Type)
        {
            $this->set($value->get());
        }
        else{
            $this->set($value);
        }
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function toInt(){
        return intval($this->getValue());
    }

    /**
     * @return string
     */
    public function toString(){
        return strval($this->getValue());
    }

    /**
     * @return bool
     */
    public function toBoolean(){
        return boolval($this->getValue());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return mixed
     */
    abstract public function get();

    /**
     * @param $v
     * @return mixed
     */
    abstract public function set($v);
}

/**
 * Class ETypeException
 */
class TypeException extends BBException{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct("wrong type");
    }
}

/**
 * Class EIntegerException
 */
class IntegerException extends TypeException{}

/**
 * Class EStringException
 */
class StringException extends TypeException{}

/**
 * Class EBooleanException
 */
class BooleanException extends TypeException{}

/**
 * Class ESetException
 */
class SetException extends TypeException{}

/**
 * Class NullIDException
 */
class NullIDException extends TypeException{}

/**
 * Class Integer
 */
class Integer extends Type{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct((int)$value);
    }

    /**
     * @return int
     * @throws IntegerException
     */
    public function get(){
        if(!is_int(parent::getValue())) throw new IntegerException;
        return parent::toInt();
    }

    /**
     * @param $v
     * @return void
     * @throws IntegerException
     */
    public function set($v){
        if(!is_integer($v)) throw new IntegerException;
        parent::setValue($v);
    }


}

/**
 * Class IDType
 */
class IDType extends Integer{
    public function get()
    {
        if($this->getValue() <= 0) throw new NullIDException($this->getValue());
        return parent::get();
    }

    public function set($v)
    {
        if($v <=0)  throw new NullIDException($this->getValue());
        parent::set($v);
    }
}

/**
 * Class UserID
 */
class UserID extends IDType{};

/**
 * Class CamID
 */
class CamID extends IDType{};

/**
 * Class Port
 */
class Port extends Integer{};

/**
 * Class String
 */
class String extends Type{
    /**
     * @return string
     * @throws StringException
     */
    public function get()
    {
        if(!is_string(parent::getValue())) throw new StringException;
        return parent::toString();
    }

    /**
     * @param $v
     * @return void
     * @throws StringException
     */
    public function set($v){
        if(!is_string($v)) throw new StringException;
        parent::setValue($v);
    }

}

/**
 * Class NameType
 */
class NameType extends String{}

/**
 * Class CamName
 */
class CamName extends NameType{};

class OrgName extends NameType{};

/**
 * Class CamPrefix
 */
class CamPrefix extends NameType{
    const LIVE = 'live';
    const RECORD = "rec";
    const MOTION = 'mtn';
    const LHTTP = 'lhttp';

    private static $prefixes = array(
        CamPrefix::LIVE,
        CamPrefix::RECORD,
        CamPrefix::MOTION,
        CamPrefix::LHTTP, //stop livehttp
    );

    /**
     * @return array
     */
    public static function getPrefixes()
    {
        return self::$prefixes;
    }
};
/**
 * Class Url
 */
class Url extends String{};

/**
 * Class Path
 */
class Path extends String{};

/**
 * Class WebPath
 */
class WebPath extends String{};

/**
 * Class WebProto
 */
class WebProto extends String{};

/**
 * Class FilePath
 */
class FilePath extends String{};

/**
 * Class Command
 */
class Command extends String{};

/**
 * Class BashCommand
 */
class BashCommand extends Command{
    public function __construct($value)
    {
        if(strlen($value) < 2) throw new CommandException();
        parent::__construct($value);
    }

    /**
     * @return BashResult last line
     */
    public function exec(){
        return new BashResult(exec($this->get()));
    }

    /**
     * @return BashResult
     */
    public function shell_exec(){
        return new BashResult(shell_exec($this->get()));
    }

};

/**
 * Class CommandException
 */
class CommandException extends TypeException{}

/**
 * Class BashCommandException
 */
class BashCommandException extends CommandException{}

/**
 * Class BashResult
 */
class BashResult extends String{}

/**
 * Class VLCCommand
 */
class VLCCommand extends Command{};

/**
 * Class VLMCommand
 */
class VLMCommand extends Command{};

class VLMInput extends VLMCommand{};
class VLMOutput extends VLMCommand{};

/**
 * Class IP
 */
class IP extends String{};

/**
 * Class Boolean
 */
class Boolean extends Type{
    /**
     * @return bool
     * @throws BooleanException
     */
    public function get()
    {
        if(!is_bool(parent::getValue())) throw new BooleanException;
        return parent::toBoolean();
    }

    /**
     * @param $v
     * @return void
     * @throws BooleanException
     */
    public function set($v)
    {
        if(!is_bool(($v))) throw new BooleanException;
        parent::setValue($v);
    }

    /**
     * @return string
     */
    public function toString()
    {
        /*
         * if("true") = 1
         * if("false") = 1
         * if("0") = 0
         * if("1") = 1
         */
        if(parent::getValue())
            return "1";
        else
            return "0";
    }
}

/**
 * Class OkFail
 */
class OkFail extends Boolean{}

/**
 * Class YesNo
 */
class YesNo extends Boolean{}

/**
 * Class Set
 */
class Set extends Type{
    /**
     * @return array
     * @throws SetException
     */
    public function get()
    {
        if(!is_array(parent::getValue())) throw new SetException;
        return parent::getValue();
    }

    /**
     * @param array $v
     * @return void
     * @throws SetException
     */
    public function set($v)
    {
        if(!is_array($v)) throw new SetException;
        parent::setValue($v);
    }

    /**
     * @return string
     */
    public function toString()
    {
        $ret = '';
        foreach(parent::getValue() as $k=>$v)
            $ret.= $k.":".$v.";";
        return $ret;
    }


}
