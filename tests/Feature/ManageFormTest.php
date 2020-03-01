<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;

class ManageFormTest extends TestCase
{

    /** @test */
    public function chart_by_default_requires_no_date_to_render()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function chart_by_default_renders_data_from_ten_days_ago()
    {
        $endDate = Carbon::today()->format('Y-m-d');
        $startDate = Carbon::today()->subday(10)->format('Y-m-d');
        // filter 10 days data
        $lastTenDaysFilterResponse = $this->get("/?start-date=${startDate}&end-date=${endDate}")->getContent();
        //default data
        $defaultResponse = $this->get('/')->getContent();
        $this->assertEquals($defaultResponse, $lastTenDaysFilterResponse);
    }

    /** @test */
    public function date_picker_accepts_Y_m_d_format()
    {
        $correctDateFormat = '2020-01-23';
        $wrongDateFormat = '01-23-2020';
        // wrong format
        $response = $this->get("/?start-date=${wrongDateFormat}&end-date=${wrongDateFormat}");
        $response->assertSessionHasErrors('start-date');
        $response->assertSessionHasErrors('end-date');
        $response->assertStatus(302);
        //correct format
        $response = $this->get("/?start-date=${correctDateFormat}&end-date=${correctDateFormat}");
        $response->assertStatus(200);
    }

    /** @test */
    public function start_date_must_be_before_or_same_as_end_date()
    {
        $wrongStartDate = Carbon::today()->format('Y-m-d');
        $endDate = Carbon::yesterday()->format('Y-m-d');
        $correctStartDate = Carbon::yesterday()->subday(5)->format('Y-m-d');
        // wrong start date
        $response = $this->get("/?start-date=${wrongStartDate}&end-date=${endDate}");
        $response->assertSessionHasErrors('start-date');
        $response->assertStatus(302);
        //correct start date
        $response = $this->get("/?start-date=${correctStartDate}&end-date=${endDate}");
        $response->assertStatus(200);
    }

        /** @test */
    public function latest_end_day_is_today()
    {
        $wrongEndDate = Carbon::tomorrow()->format('Y-m-d');
        $correctEndDate = Carbon::today()->format('Y-m-d');
        $startDate = Carbon::today()->subday(4)->format('Y-m-d');
        // wrong end date
        $response = $this->get("/?start-date=${startDate}&end-date=${wrongEndDate}");
        $response->assertSessionHasErrors('end-date');
        $response->assertStatus(302);
        //correct end date
        $response = $this->get("/?start-date=${startDate}&end-date=${correctEndDate}");
        $response->assertStatus(200);
    }
}
