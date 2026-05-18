<?php

use Seatplus\EsiSchema\AbstractEsiDto;
use Seatplus\EsiSchema\Responses\AllianceDetail;
use Seatplus\EsiSchema\Responses\CharactersDetail;
use Seatplus\EsiSchema\Responses\CharactersSkillsSkill;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsGetItem;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdContactsGetItem;

it('all DTOs extend AbstractEsiDto', function () {
    $dto = AllianceDetail::from((object) [
        'name' => 'Test Alliance',
        'creator_id' => 1,
        'creator_corporation_id' => 2,
        'date_founded' => '2010-01-01T00:00:00Z',
        'ticker' => 'TEST',
    ]);

    expect($dto)->toBeInstanceOf(AbstractEsiDto::class);
});

it('AbstractEsiDto metadata defaults are sane', function () {
    $dto = AllianceDetail::from((object) [
        'name' => 'Test Alliance',
        'creator_id' => 1,
        'creator_corporation_id' => 2,
        'date_founded' => '2010-01-01T00:00:00Z',
        'ticker' => 'TEST',
    ]);

    expect($dto->isCachedLoad)->toBeFalse()
        ->and($dto->pages)->toBe(1)
        ->and($dto->rateLimitRemaining)->toBeNull();
});

it('AbstractEsiDto metadata is mutable after construction', function () {
    $dto = AllianceDetail::from((object) [
        'name' => 'Test Alliance',
        'creator_id' => 1,
        'creator_corporation_id' => 2,
        'date_founded' => '2010-01-01T00:00:00Z',
        'ticker' => 'TEST',
    ]);

    $dto->isCachedLoad = true;
    $dto->pages = 5;

    expect($dto->isCachedLoad)->toBeTrue()
        ->and($dto->pages)->toBe(5);
});

it('CharactersDetail::from() does not crash when optional fields are absent', function () {
    $dto = CharactersDetail::from((object) [
        'name' => 'Test Pilot',
        'corporation_id' => 98000001,
        'birthday' => '2010-01-01T00:00:00Z',
        'bloodline_id' => 1,
        'race_id' => 2,
        'gender' => 'male',
    ]);

    expect($dto->name)->toBe('Test Pilot')
        ->and($dto->corporation_id)->toBe(98000001)
        ->and($dto->alliance_id)->toBeNull();
});

it('CharactersSkillsSkill::from() survives a missing required field (CCP stealth change)', function () {
    // Simulate CCP removing active_skill_level without a new compatibility date
    $dto = CharactersSkillsSkill::from((object) [
        'skill_id' => 3300,
        'trained_skill_level' => 5,
        // active_skill_level intentionally absent
        'skillpoints_in_skill' => 512000,
    ]);

    expect($dto->active_skill_level)->toBe(0)   // defensive ?? 0 fallback
        ->and($dto->skill_id)->toBe(3300)
        ->and($dto->trained_skill_level)->toBe(5);
});

it('typed properties are correctly cast on assets DTO', function () {
    $dto = CharactersCharacterIdAssetsGetItem::from((object) [
        'item_id' => 1234567890,
        'type_id' => 35,
        'location_id' => 60003760,
        'location_type' => 'station',
        'location_flag' => 'Hangar',
        'is_singleton' => false,
        'quantity' => 100,
    ]);

    expect($dto->item_id)->toBe(1234567890)
        ->and($dto->type_id)->toBe(35)
        ->and($dto->is_singleton)->toBeFalse()
        ->and($dto->quantity)->toBe(100);
});

it('list item DTOs also extend AbstractEsiDto', function () {
    $dto = AlliancesAllianceIdContactsGetItem::from((object) [
        'contact_id' => 99000001,
        'contact_type' => 'character',
        'standing' => 5.0,
    ]);

    expect($dto)->toBeInstanceOf(AbstractEsiDto::class)
        ->and($dto->contact_id)->toBe(99000001)
        ->and($dto->standing)->toBe(5.0);
});
