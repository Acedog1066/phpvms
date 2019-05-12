<?php

use App\Repositories\SettingRepository;
use App\Support\Metar;

/**
 * Test the parsing/support class of the metar
 */
class MetarTest extends TestCase
{
    private $settingsRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->settingsRepo = app(SettingRepository::class);
    }

    /**
     * Make sure a blank metar doesn't give problems
     */
    public function testBlankMetar()
    {
        $metar = '';
        $parsed = Metar::parse($metar);
        $this->assertEquals('', $parsed['raw']);
    }

    /**
     * Test adding/subtracting a percentage
     */
    public function testMetar1()
    {
        $metar =
            'KJFK 042151Z 28026G39KT 10SM FEW055 SCT095 BKN110 BKN230 12/M04 A2958 RMK AO2 PK WND 27045/2128 PRESRR SLP018 T01221044';

        //$m = new Metar($metar);
        //$parsed = $m->result;
        $parsed = Metar::parse($metar);

        /*
            Conditions  VFR visibility 10NM
            Barometer   1001.58 Hg / 29.58 MB
            Clouds      FEW @ 5500 ft
                        SCT @ 9500 ft
                        BKN @ 11000 ft
                        BKN @ 23000 ft
            Wind        26 kts @ 280° gusts to 39
         */
        $this->assertEquals('KJFK', $parsed['station']);
        $this->assertEquals(4, $parsed['observed_day']);
        $this->assertEquals('21:51 UTC', $parsed['observed_time']);
        $this->assertEquals(13.38, $parsed['wind_speed']);
        $this->assertEquals(20.06, $parsed['wind_gust_speed']);
        $this->assertEquals(280, $parsed['wind_direction']);
        $this->assertEquals('W', $parsed['wind_direction_label']);
        $this->assertEquals(false, $parsed['wind_direction_varies']);
        $this->assertEquals(16093.44, $parsed['visibility']['m']);
        $this->assertEquals('Dry', $parsed['present_weather_report']);

        $this->assertCount(4, $parsed['clouds']);
        $this->assertEquals(
            'A few at 1676 meters; scattered at 2896 meters; broken sky at 3353 meters; broken sky at 7010 meters',
            $parsed['clouds_report']);
        $this->assertEquals(1676.4, $parsed['cloud_height']['m']);
        $this->assertEquals(false, $parsed['cavok']);

        $this->assertEquals(12, $parsed['temperature']['c']);
        $this->assertEquals(53.6, $parsed['temperature']['f']);

        $this->assertEquals(-4, $parsed['dew_point']['c']);
        $this->assertEquals(24.8, $parsed['dew_point']['f']);

        $this->assertEquals(33, $parsed['humidity']);
        $this->assertEquals(29.58, $parsed['barometer']);
        $this->assertEquals(0.87, $parsed['barometer_in']);

        $this->assertEquals('AO2 PK WND 27045/2128 PRESRR SLP018 T01221044', $parsed['remarks']);
    }

    public function testMetar2()
    {
        $metar = 'EGLL 261250Z AUTO 17014KT 8000 -RA BKN010/// '
                .'BKN016/// OVC040/// //////TCU 13/12 Q1008 TEMPO 4000 RA';

        $parsed = Metar::parse($metar);

        $this->assertCount(4, $parsed['clouds']);
        $this->assertEquals(1000, $parsed['clouds'][0]['height']['ft']);
        $this->assertEquals(1600, $parsed['clouds'][1]['height']['ft']);
        $this->assertEquals(4000, $parsed['clouds'][2]['height']['ft']);
        $this->assertNull($parsed['clouds'][3]['height']['ft']);
    }

    public function testMetar3()
    {
        $metar = 'LEBL 310337Z 24006G18KT 210V320 1000 '
                .'R25R/P2000 R07L/1900N R07R/1700D R25L/1900N '
                .'+TSRA SCT006 BKN015 SCT030CB 22/21 Q1018 NOSIG';

        $parsed = Metar::parse($metar);
    }

    public function testMetarTrends()
    {
        $metar =
            'KJFK 070151Z 20005KT 10SM BKN100 08/07 A2970 RMK AO2 SLP056 T00780067';

        /**
         * John F.Kennedy International, New York, NY (KJFK). Apr 7, 0151Z. Wind from 200° at 5 knots,
         * 10 statute miles visibility, Ceiling is Broken at 10,000 feet, Temperature 8°C, Dewpoint 7°C,
         * Altimeter is 29.70. Remarks: automated station with precipitation discriminator sea level
         * pressure 1005.6 hectopascals hourly temp 7.8°C dewpoint 6.7°C
         */
        $parsed = Metar::parse($metar);
    }

    public function testMetarTrends2()
    {
        $metar = 'KAUS 092135Z 26018G25KT 8SM -TSRA BR SCT045CB BKN060 OVC080 30/21 A2992 RMK FQT LTGICCCCG OHD-W MOVG E  RAB25 TSB32 CB ALQDS  SLP132 P0035 T03020210 =';
        $parsed = Metar::parse($metar);

        $this->assertEquals('VFR', $parsed['category']);
        $this->assertEquals(9.26, $parsed['wind_speed']);
        $this->assertEquals(8, $parsed['visibility']['mi']);
        $this->assertEquals(
            'Scattered at 4500 feet, cumulonimbus; broken sky at 6000 feet; overcast sky at 8000 feet',
            $parsed['clouds_report_ft']
        );

        $this->assertNotNull($parsed);
    }

    public function testMetarTrends3()
    {
        $metar = 'EHAM 041455Z 13012KT 9999 FEW034CB BKN040 05/01 Q1007 TEMPO 14017G28K 4000 SHRA =';
        $metar = Metar::parse($metar);

        $this->assertEquals('VFR', $metar['category']);
        $this->assertNotNull($metar);
    }
}
