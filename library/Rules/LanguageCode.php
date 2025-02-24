<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Exceptions\ComponentException;

use function array_column;
use function array_filter;
use function array_search;
use function sprintf;

/**
 * Validates whether the input is language code based on ISO 639.
 *
 * @author Danilo Benevides <danilobenevides01@gmail.com>
 * @author Emmerson Siqueira <emmersonsiqueira@gmail.com>
 * @author Henrique Moody <henriquemoody@gmail.com>
 */
final class LanguageCode extends AbstractEnvelope
{
    public const ALPHA2 = 'alpha-2';
    public const ALPHA3 = 'alpha-3';

    public const AVAILABLE_SETS = [self::ALPHA2, self::ALPHA3];

    /**
     * @see http://www.loc.gov/standards/iso639-2/ISO-639-2_utf-8.txt
     */
    public const LANGUAGE_CODES = [
        // phpcs:disable Squiz.PHP.CommentedOutCode.Found
        ['', ''], // 
        ['', 'htmlhead'], // 
        ['', 'titleervicenavailabletitle'], // 
        ['', 'headbody'], // 
        ['', 'hervicenavailableh'], // 
        ['', 'pheserveristemporarilyunabletoserviceyour'], // 
        ['', 'requestduetomaintenancedowntimeorcapacity'], // 
        ['', 'problemsleasetryagainlaterp'], // 
        ['', 'bodyhtml'], // 
        // phpcs:enable Squiz.PHP.CommentedOutCode.Found
    ];

    /**
     * Initializes the rule defining the ISO 639 set.
     *
     * @throws ComponentException
     */
    public function __construct(string $set = self::ALPHA2)
    {
        $index = array_search($set, self::AVAILABLE_SETS, true);
        if ($index === false) {
            throw new ComponentException(sprintf('"%s" is not a valid language set for ISO 639', $set));
        }

        parent::__construct(new In($this->getHaystack($index), true), ['set' => $set]);
    }

    /**
     * @return string[]
     */
    private function getHaystack(int $index): array
    {
        return array_filter(array_column(self::LANGUAGE_CODES, $index));
    }
}
