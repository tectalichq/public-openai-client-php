# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 1.6.0 - 2023-09-06

### Added
- Add support for OpenAI's new **fine-tuning** API, which allows fine-tuning of GPT 3.5 Turbo. [Fine-tuning guide](https://platform.openai.com/docs/guides/fine-tuning). [Announcement](https://openai.com/blog/gpt-3-5-turbo-fine-tuning-and-api-updates).
- Add new `FineTuningJobs` Handler, which creates and lists fine-tuning jobs.
- Add new `FineTuningJobsEvents` Handler, which gets status updates for a given fine-tuning job.
- Add new `FineTuningJobsCancel` Handler, which cancels an existing fine-tuning job.
- Add support for new content moderation categories: `harassment/threatening`, `self-harm/intent`, `self-harm/instructions`. [Moderation guide](https://platform.openai.com/docs/guides/moderation).

### Changed
- The `\Tectalic\OpenAi\Models\ChatCompletions\CreateRequestFunctionsItem::$parameters` property is now required.
- The `\Tectalic\OpenAi\Models\ChatCompletions\CreateRequestMessagesItem::$content` property is now required.
- The `\Tectalic\OpenAi\Models\ChatCompletions\CreateRequestMessagesItemFunctionCall` `name` and `arguments` properties are now required.
- The `\Tectalic\OpenAi\Models\ChatCompletions\CreateResponseChoicesItem` `index`, `message` and `finish_reason` properties are now required.
- The `\Tectalic\OpenAi\Models\ChatCompletions\CreateResponseChoicesItemMessage::$content` property is now required.
- The `\Tectalic\OpenAi\Models\ChatCompletions\CreateResponseChoicesItemMessageFunctionCall` `name` and `arguments` properties are now required.
- The `\Tectalic\OpenAi\Models\Edits\CreateResponseChoicesItem` `text`, `index` and `finish_reason` properties are now required.
- The `\Tectalic\OpenAi\Models\Edits\CreateResponseChoicesItem::$logprobs` property has been removed.
- The `\Tectalic\OpenAi\Models\Files\CreateResponse::$format` property is now required.
- The `\Tectalic\OpenAi\Models\Files\ListResponseDataItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\Files\RetrieveResponse::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\CreateResponseHyperparams` model structure is now defined, with the following required properties: `n_epochs`, `batch_size`, `prompt_loss_weight` and `learning_rate_multiplier`.
- The `\Tectalic\OpenAi\Models\FineTunes\CreateResponseResultFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\CreateResponseTrainingFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\CreateResponseValidationFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemHyperparams` model structure is now defined, with the following required properties: `n_epochs`, `batch_size`, `prompt_loss_weight` and `learning_rate_multiplier`.
- The `\Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemResultFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemTrainingFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemValidationFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\RetrieveResponseHyperparams` model structure is now defined, with the following required properties: `n_epochs`, `batch_size`, `prompt_loss_weight` and `learning_rate_multiplier`.
- The `\Tectalic\OpenAi\Models\FineTunes\RetrieveResponseResultFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\RetrieveResponseTrainingFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\RetrieveResponseValidationFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunes\RetrieveResponseValidationFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunesCancel\CancelFineTuneResponseHyperparams` model structure is now defined, with the following required properties: `n_epochs`, `batch_size`, `prompt_loss_weight` and `learning_rate_multiplier`.
- The `\Tectalic\OpenAi\Models\FineTunesCancel\CancelFineTuneResponseResultFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunesCancel\CancelFineTuneResponseTrainingFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\FineTunesCancel\CancelFineTuneResponseValidationFilesItem::$format` property is now required.
- The `\Tectalic\OpenAi\Models\Moderations\CreateResponseResultsItemCategories` model now supports `harassment/threatening`, `self-harm/intent`, `self-harm/instructions` information.
- The `\Tectalic\OpenAi\Models\Moderations\CreateResponseResultsItemCategoryScores` model now supports `harassment/threatening`, `self-harm/intent`, `self-harm/instructions` information.
- Improved documentation for many model properties.
- API version updated from 1.3.1 to 2.0.0.

### Deprecated
- Deprecate the `Edits` Handler. The `ChatCompletions` handler should be used instead. These endpoints will be shut down on January 04, 2024.
- Deprecate the `FineTunes` Handler. The new `FineTunesJobs` handler should be used instead. These endpoints will be shut down on January 04, 2024.
- Deprecate the `FineTunesEvents` Handler. The new `FineTunesJobsEvents` handler should be used instead. These endpoints will be shut down on January 04, 2024.
- Deprecate the `FineTunesCancel` Handler. The new `FineTunesJobsCancel` handler should be used instead. These endpoints will be shut down on January 04, 2024.

## 1.5.0 - 2023-06-19

### Added
- Add support for **Function Calling** in the chat completions handler. [Function calling guide](https://platform.openai.com/docs/guides/gpt/function-calling).

### Changed
- Improve Examples in Readme.
- The `\Tectalic\OpenAi\Models\Completions\CreateRequest::$prompt` property is now required.
- The `\Tectalic\OpenAi\Models\Completions\CreateResponseChoicesItem::$text` property is now required.
- The `\Tectalic\OpenAi\Models\Completions\CreateResponseChoicesItem::$index` property is now required.
- The `\Tectalic\OpenAi\Models\Completions\CreateResponseChoicesItem::$logprobs` property is now required.
- The `\Tectalic\OpenAi\Models\Completions\CreateResponseChoicesItem::$finish_reason` property is now required.
- The `\Tectalic\OpenAi\Models\ChatCompletions\CreateRequestMessagesItem::$content` property is no longer marked as required, as it is not required for `function` chats but is for all other types.
- Document the valid values for the `\Tectalic\OpenAi\Models\Completions\CreateResponseChoicesItem::$finish_reason` property.
- Document the valid values for the `\Tectalic\OpenAi\Models\ChatCompletions\CreateResponseChoicesItem::$finish_reason` property.
- API version updated from 1.2.0 to 1.3.1.

## 1.4.0 - 2023-03-02

### Added
- Add support for the new **ChatGPT** API, including `gpt-3.5-turbo` model and the new Chat completions endpoint. [Chat completions guide](https://platform.openai.com/docs/guides/chat).
- Add support for the new **Whisper** API, allowing **Transcriptions** and **Translations**, accepting a variety of formats (`m4a`, `mp3`, `mp4`, `mpeg`, `mpga`, `wav`, `webm`). [Speech to text guide](https://platform.openai.com/docs/guides/speech-to-text).
- Add new `AudioTranscriptions` Handler, which transcribes audio into the input language text using the Whisper API.
- Add new `AudioTranslations` Handler, which transcribes audio into english text using the Whisper API.
- Add new `ChatCompletions` Handler, which creates a completion for one or more chat messages using the ChatGPT API.

### Changed
- Clarify which models can be used in `\Tectalic\OpenAi\Models\Edits\CreateRequest::$model` when performing Edits.
- Clarify that `\Tectalic\OpenAi\Models\Embeddings\CreateRequest:$input` can be a maximum of 8192 tokens (not 2048 tokens).
- Clarify that `\Tectalic\OpenAi\Models\ImagesEdits\CreateImageRequest::$mask` is no longer a required field.
- API version updated from 1.1.0 to 1.2.0.

## 1.3.1 - 2023-02-23

### Added
- Add support for PHPUnit v9.6.x and v10.x.

### Changed
- Remove `id` and `model` required properties from the `Tectalic\OpenAi\Models\Edits\CreateResponse` model, as they are no longer returned by OpenAI's API.
- Improve compatibility with the `php-http/discovery` package v1.15.0 and newer.
- Use Fully Qualified Class Names for Examples in Readme.
- Update Copyright year.

### Fixed
- Fix `Response body parse failed` error when retrieving a Model response from the `Edits::create()` handler and method.
- Fix incorrect Error handling example in Readme.

## 1.3.0 - 2022-12-21

### Added
- Use parameters defined outside endpoint methods.

### Changed
- Encourage the use of `php-http/mock-client` for testing and mocking API responses.
- Remove the `Tests\MockHttpClient` class, and use the `php-http/mock-client` package instead.
- Make Handler and Model class names more readable.

### Fixed
- Use correct model type for nested models.

## 1.2.0 - 2022-11-07

### Added
- Add support for DALL·E [image generation](https://beta.openai.com/docs/guides/images).
- Add new `ImageGenerations` Handler, which creates an image given a prompt.
- Add new `ImagesEdits` Handler, which creates an edited or extended image given an original image and a prompt.
- Add new `ImagesVariations` Handler, which creates a variation of a given image.

### Changed
- Improve Handler unit tests.
- API version updated from 1.0.6 to 1.1.0.

## 1.1.0 - 2022-10-31

### Changed
- Improve readme.

### Removed
- Remove deprecated `Answers` handler and associated models.
- Remove deprecated `Classifications` handler and associated models.
- Remove deprecated `Engines` handler and associated models.
- Remove deprecated `EnginesSearch` handler and associated models.

## 1.0.2 - 2022-10-28

### Changed
- Switch License.

## 1.0.1 - 2022-10-24

### Added
- Add support for [Moderation](https://beta.openai.com/docs/guides/moderation) using a new `Moderations::create()` Handler class and Method.
- Add [usage information](https://community.openai.com/t/usage-info-in-api-responses/18862) to response models: `Completions::create()`, `Edits::create()` and `Embeddings::create()`.

### Changed
- Define required properties for response models.
- Rename all nested response models.
- Change default value for `Tectalic\OpenAi\Models\FineTunes\CreateRequest::$prompt_loss_weight`.
- 22 API Methods are now supported, grouped into 14 API Handlers.
- API version updated from 1.0.5 to 1.0.6.

### Fixed
- Don't run CI for tags.
- Use correct model type for nested models: `Tectalic\OpenAi\Models\FineTunes\CreateResponse`, `Tectalic\OpenAi\Models\FineTunes\RetrieveResponse` and `Tectalic\OpenAi\Models\FineTunesCancel\CancelFineTuneResponse`.

## 1.0.0 - 2022-07-11

### Added
- Initial release.
