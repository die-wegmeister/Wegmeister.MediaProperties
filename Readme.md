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
    assetCollections:
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

Then use the property in your fusion files:

```
prototype(Vendor.Package:NodeType) < prototype(Neos.Neos:ContentComponent) {
    # Multiple Tags / Asset Collections
    tags = ${q(node).property('tags')}
    assetCollections = ${q(node).property('assetCollections')}

    # Single Tag / Asset Collection
    tag = ${q(node).property('tag')}
    assetCollection = ${q(node).property('assetCollection')}

    renderer = afx`
        <div>
            <h2>Tags</h2>
            <Neos.Fusion:Loop items={props.tags}>
                <p>{tag.label}</p>

                <!-- 
                    You can access all properties of the tag here, 
                    even loop through the asset collections
                -->
                <Neos.Fusion:Loop items={tag.assetCollections}>
                    <p>Asset Collection: {assetCollection.title}</p>
                </Neos.Fusion:Loop>
            </Neos.Fusion:Loop>

            <!-- Same for asset collections -->

            <!-- Single Tag / Asset Collection -->
            <h2>Single Tag</h2>
            <p>{props.tag.label}</p>

            <h2>Single Asset Collection</h2>
            <p>{props.assetCollection.title}</p>
        </div>
    `
}
