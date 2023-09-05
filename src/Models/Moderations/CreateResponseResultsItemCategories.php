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

final class CreateResponseResultsItemCategories extends AbstractModel
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
     * Content that expresses, incites, or promotes hate based on race, gender,
     * ethnicity, religion, nationality, sexual orientation, disability status, or
     * caste. Hateful content aimed at non-protected groups (e.g., chess players) is
     * harrassment.
     *
     * @var bool
     */
    public $hate;

    /**
     * Hateful content that also includes violence or serious harm towards the targeted
     * group based on race, gender, ethnicity, religion, nationality, sexual
     * orientation, disability status, or caste.
     *
     * @var bool
     */
    public $hateThreatening;

    /**
     * Content that expresses, incites, or promotes harassing language towards any
     * target.
     *
     * @var bool
     */
    public $harassment;

    /**
     * Harassment content that also includes violence or serious harm towards any
     * target.
     *
     * @var bool
     */
    public $harassmentThreatening;

    /**
     * Content that promotes, encourages, or depicts acts of self-harm, such as
     * suicide, cutting, and eating disorders.
     *
     * @var bool
     */
    public $selfHarm;

    /**
     * Content where the speaker expresses that they are engaging or intend to engage
     * in acts of self-harm, such as suicide, cutting, and eating disorders.
     *
     * @var bool
     */
    public $selfHarmIntent;

    /**
     * Content that encourages performing acts of self-harm, such as suicide, cutting,
     * and eating disorders, or that gives instructions or advice on how to commit such
     * acts.
     *
     * @var bool
     */
    public $selfHarmInstructions;

    /**
     * Content meant to arouse sexual excitement, such as the description of sexual
     * activity, or that promotes sexual services (excluding sex education and
     * wellness).
     *
     * @var bool
     */
    public $sexual;

    /**
     * Sexual content that includes an individual who is under 18 years old.
     *
     * @var bool
     */
    public $sexualMinors;

    /**
     * Content that depicts death, violence, or physical injury.
     *
     * @var bool
     */
    public $violence;

    /**
     * Content that depicts death, violence, or physical injury in graphic detail.
     *
     * @var bool
     */
    public $violenceGraphic;
}
