# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 1.2.0 - 2022-11-07

### Added
- Add support for DALL·E [image generation](https://beta.openai.com/docs/guides/images).
- Add new `ImageGenerations` Handler, which creates an image given a prompt.
- Add new `ImagesEdits` Handler, which creates an edited or extended image given an original image and a prompt
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
