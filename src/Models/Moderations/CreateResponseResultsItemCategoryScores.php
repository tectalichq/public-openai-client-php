<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Moderations;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateResponseResultsItemCategoryScores extends AbstractModel
{
    /**
     * List of properties names that are different in this model compared to the API.
     *
     * Array key is this model's property name, array value is the API's property name.
     */
    protected const MAPPED = [
        'hateThreatening' => 'hate/threatening',
        'harassmentThreatening' => 'harassment/threatening',
        'selfHarm' => 'self-harm',
        'selfHarmIntent' => 'self-harm/intent',
        'selfHarmInstructions' => 'self-harm/instructions',
        'sexualMinors' => 'sexual/minors',
        'violenceGraphic' => 'violence/graphic',
    ];

    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = [
        'hate',
        'hateThreatening',
        'harassment',
        'harassmentThreatening',
        'selfHarm',
        'selfHarmIntent',
        'selfHarmInstructions',
        'sexual',
        'sexualMinors',
        'violence',
        'violenceGraphic',
    ];

    /**
     * The score for the category 'hate'.
     *
     * @var float|int
     */
    public $hate;

    /**
     * The score for the category 'hate/threatening'.
     *
     * @var float|int
     */
    public $hateThreatening;

    /**
     * The score for the category 'harassment'.
     *
     * @var float|int
     */
    public $harassment;

    /**
     * The score for the category 'harassment/threatening'.
     *
     * @var float|int
     */
    public $harassmentThreatening;

    /**
     * The score for the category 'self-harm'.
     *
     * @var float|int
     */
    public $selfHarm;

    /**
     * The score for the category 'self-harm/intent'.
     *
     * @var float|int
     */
    public $selfHarmIntent;

    /**
     * The score for the category 'self-harm/instructions'.
     *
     * @var float|int
     */
    public $selfHarmInstructions;

    /**
     * The score for the category 'sexual'.
     *
     * @var float|int
     */
    public $sexual;

    /**
     * The score for the category 'sexual/minors'.
     *
     * @var float|int
     */
    public $sexualMinors;

    /**
     * The score for the category 'violence'.
     *
     * @var float|int
     */
    public $violence;

    /**
     * The score for the category 'violence/graphic'.
     *
     * @var float|int
     */
    public $violenceGraphic;
}
