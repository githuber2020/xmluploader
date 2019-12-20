<?php
namespace My\Helper;

class AddressParseHelper
{
    /**
     * @var array Address with parsed attributes
     */
    protected $address = [];

    /**
     * @var array Map of reg exp patterns for address attributes
     */
    protected $attrRegExpMap = [
        'region' => ['pattern' => '/([^,]+) (ОБЛ.|обл.)/', 'matchIndex' => 1],
        'place' => ['pattern' => '/(МІСТО|місто) ([^,]+)/', 'matchIndex' => 2],
        'district' => ['pattern' => '/([^,]+) (РАЙОН|район)/', 'matchIndex' => 1],
        'street' => ['pattern' => '/((ВУЛ|вул|ВУЛИЦЯ|вулиця|ПРОВУЛОК|провулок)[ \.]([^,]+))/', 'matchIndex' => 1],
        'house' => ['pattern' => '/(БУД|буд|БУДИНОК|будинок)[ \.]([^,]+)/', 'matchIndex' => 2],
        'num' => []
    ];

    /**
     * Save address with parsed attributes to internal property $this->address
     *
     * @param string $adressStr
     *
     * @return void
     */
    public function __construct($adressStr)
    {
        $this->address['description'] = $adressStr;
        $this->parseAttributes($adressStr);
    }

    /**
     * Parse address attributes
     *
     * @param $adressStr
     *
     * @return void
     */
    protected function parseAttributes($adressStr)
    {
        foreach ($this->attrRegExpMap as $attrName => $repExpArr) {
            $this->address[$attrName] = $this->parseAttrValueFromStr($adressStr, $repExpArr['pattern'], $repExpArr['matchIndex']);
        }
    }

    /**
     * Parse string with regExpPattern
     *
     * @param string $adressStr
     * @param string $regExpPattern
     * @param int $matchIndex
     *
     * @return string
     */
    public function parseAttrValueFromStr($adressStr, $regExpPattern, $matchIndex)
    {
        if (!$regExpPattern || !$adressStr || !$matchIndex) {
            return '';
        }

        preg_match($regExpPattern, $adressStr, $matches);

        return $matches[$matchIndex];
    }

    /**
     * Return json string of parsed address
     *
     * @return string
     */
    public function toJsonStr()
    {
        return json_encode($this->address);
    }
}