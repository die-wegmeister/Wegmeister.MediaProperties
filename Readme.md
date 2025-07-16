# Wegmeister.MediaProperties

This package provides additional media properties for Neos CMS, that allow you to choose tags and asset collections from the Media package.

## Installation

From within your Site package, run:

```bash
composer require --no-update wegmeister/media-properties
```

Then run the following command in your project root:

```bash
composer update
```

## Usage

This package provides presets and data types for tags and asset collections. To use them, add the following lines to your `NodeTypes.yaml` file:

<details>
<summary>Multiple Tags / Asset collections</summary>

```yaml
'Vendor.Package:NodeType':
  properties:
    ##
    # Tags
    ##
    tags:
      # either use type or the options preset, not both
      type: array<Neos\Media\Domain\Model\Tag>
      # options:
      #   preset: tags
      ui:
        label: Tags
        inspector:
          group: default
          # Optionally, only show tags that are linked to one of the given asset collections
          editorOptions:
            dataSourceAdditionalData:
              assetCollections:
                - 'Title of Asset collection'

    ##
    # Asset Collections
    ##
    assetCollectionsUsingPreset:
      # either use type or the options preset, not both
      type: array<Neos\Media\Domain\Model\AssetCollection>
      # options:
      #   preset: assetCollections
      ui:
        label: Asset Collections
        inspector:
          group: default
```
</details>

<details>
<summary>Single Tag / Asset collection</summary>

```yaml
'Vendor.Package:NodeType':
  properties:
    ##
    # Single Tag
    ##
    tag:
      # either use type or the options preset, not both
      type: Neos\Media\Domain\Model\Tag
      # options:
      #   preset: tags
      ui:
        label: Tag
        inspector:
          group: default
          # Optionally, only show tags that are linked to one of the given asset collections
          editorOptions:
            dataSourceAdditionalData:
              assetCollections:
                - 'Title of Asset collection'
    ##
    # Single Asset Collection
    ##
    assetCollection:
      # either use type or the options preset, not both
      type: Neos\Media\Domain\Model\AssetCollection
      # options:
      #   preset: assetCollections
      ui:
        label: Asset Collection
        inspector:
          group: default
```
</details>
