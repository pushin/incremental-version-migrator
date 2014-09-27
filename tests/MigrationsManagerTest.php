<?php
namespace Pushin\IncrementalVersionMigrator\Tests;

class MigrationsManagerTest extends BaseTestCase
{

    public function testIsValidVersionNumber()
    {
        $manager = $this->buildManager();
        $this->assertSame(0, $manager->getLastVersion());

        $manager = $this->buildManager(array(
            new Migration(14),
            new Migration(190),
            new Migration(56),
            new Migration(4),
            new Migration(65),
        ));

        $this->assertFalse($manager->isValidVersionNumber('14'));
        $this->assertFalse($manager->isValidVersionNumber(15));
        $this->assertFalse($manager->isValidVersionNumber('0'));
        $this->assertTrue($manager->isValidVersionNumber(0));
        $this->assertTrue($manager->isValidVersionNumber(4));
        $this->assertTrue($manager->isValidVersionNumber(190));
    }

    public function testGetLastVersion()
    {
        $manager = $this->buildManager();
        $this->assertSame(0, $manager->getLastVersion());

        $manager = $this->buildManager(array(
            new Migration(14),
            new Migration(190),
            new Migration(56),
            new Migration(4),
            new Migration(65),
        ));
        $this->assertSame(190, $manager->getLastVersion());
    }

    /**
     * @expectedException \Pushin\IncrementalVersionMigrator\InvalidVersionNumberException
     */
    public function testGetChainInvalidVersions()
    {
        $manager = $this->buildManager();
        $manager->getChain(1, 4);
    }

    /**
     * @param $from
     * @param $to
     * @param $expected
     * @dataProvider testGetChainProvider
     */
    public function testGetChain($from, $to, $expected)
    {
        $manager = $this->buildManager(array(
            new Migration(14),
            new Migration(190),
            new Migration(56),
            new Migration(4),
            new Migration(65),
        ));

        $this->assertSame($expected, array_keys($manager->getChain($from, $to)->getMigrations()));

    }

    public function testGetChainProvider()
    {
        return array(
            array(0, 4, array(4)),
            array(0, 56, array(4, 14, 56)),
            array(0, 190, array(4, 14, 56, 65, 190)),
            array(4, 190, array(14, 56, 65, 190)),
            array(65, 190, array(190)),

            array(0, 0, array()),
            array(190, 190, array()),

            array(190, 0, array(190, 65, 56, 14, 4)),
            array(190, 65, array(190)),
            array(190, 14, array(190, 65, 56)),
            array(56, 0, array(56, 14, 4)),
            array(65, 14, array(65, 56)),
        );
    }

    public function testHasMigration()
    {
        $manager = $this->buildManager();

        $this->assertTrue($manager->hasMigration(0));
        $this->assertFalse($manager->hasMigration(1));

        $manager = $this->buildManager(array(
            new Migration(1),
            new Migration(4),
        ));

        $this->assertTrue($manager->hasMigration(0));
        $this->assertTrue($manager->hasMigration(1));
        $this->assertTrue($manager->hasMigration(4));
        $this->assertFalse($manager->hasMigration(2));

    }
}