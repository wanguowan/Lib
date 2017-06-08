<?php
/**
 * Created by PhpStorm.
 * User: wan
 * Date: 6/8/17
 * Time: 3:12 PM
 */
class CBasicLibTest extends TestBase
{
    public function testArrayKeyPluck_1()
    {
        $arrBase = [
            'key1' => [ 'id' => 1, 'name' => 'wan1' ],
            'key2' => [ 'id' => 2, 'name' => 'wan2' ],
            'key3' => [ 'id' => 3, 'name' => 'wan3' ],
            'key4' => [ 'id' => 4, 'name' => 'wan4' ],
        ];

        $arrResult = \Wan\Lib\CBasicLib::array_key_pluck( $arrBase, 'id' );

        $this->assertEquals( $arrResult, [ 'key1' => 1, 'key2' => 2, 'key3' => 3, 'key4' => 4 ] );
    }

    public function testArrayKeyPluck_2()
    {
        $arrBase = [
            'key1' => [ 'id' => 1, 'name' => 'wan1' ],
            'key2' => [ 'id' => 2, 'name' => 'wan2' ],
            'key3' => [ 'id' => 3, 'name' => 'wan3' ],
            'key4' => [ 'id' => 4, 'name' => 'wan4' ],
        ];

        $arrResult = \Wan\Lib\CBasicLib::array_key_pluck( $arrBase, 'id1' );

        $this->assertEquals( $arrResult, [ 'key1' => null, 'key2' => null, 'key3' => null, 'key4' => null,] );
    }
}