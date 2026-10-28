<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class GuestScanFormTest extends CIUnitTestCase
{
    public function testScanRouteIsDeclaredOnlyOnceOutsideTheLoginGroup(): void
    {
        $routes = file_get_contents(APPPATH . 'Config/Routes.php');
        $scanRoute = '$routes->get(\'scan/(:segment)\'';
        $loginGroup = '$routes->group(\'\', [\'filter\' => \'login\']';

        self::assertSame(1, substr_count($routes, $scanRoute));
        self::assertLessThan(strpos($routes, $loginGroup), strpos($routes, $scanRoute));
    }

    public function testGuestScanIsExcludedFromGlobalLoginFilter(): void
    {
        $filters = file_get_contents(APPPATH . 'Config/Filters.php');

        self::assertStringContainsString("'login' => ['except' => ['scan/*']]", $filters);
    }

    public function testCreateFormContainsTheFieldsShownInTheRequestedDesign(): void
    {
        $form = file_get_contents(APPPATH . 'Views/barang/create.php');

        foreach ([
            'name="kode_aset"',
            'name="kategori_id"',
            'name="sub_kategori_id"',
            'name="nama_barang"',
            'name="ruang_id"',
            'name="no_seri"',
            'name="daya"',
            'name="tahun_pembelian"',
            'name="kepemilikan"',
            'name="kondisi_barang"',
            'name="is_active"',
            'name="foto"',
            'name="tanggal_perbaikan_terakhir"',
        ] as $field) {
            self::assertStringContainsString($field, $form, 'Missing form field: ' . $field);
        }
    }

    public function testGuestDetailTemplateExistsAndDoesNotIncludeMaintenanceHistory(): void
    {
        $template = APPPATH . 'Views/scan/detail.php';
        self::assertFileExists($template);
        $detail = file_get_contents($template);
        self::assertStringNotContainsString('sarpras_maintenance', $detail);
        self::assertStringNotContainsString('tanggal_maintenance', $detail);
    }
}
