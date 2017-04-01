# Adapt2Docx2 (uses components file)

Convert adapt2 elearning pages into docx for easy client review.

NOTE: It does not do the inverse! So you still have to apply changes by hand, or just use the authoring tool.

## Requirements

* Adapt 2 framework >2.0.11
* php command line

## Step 1 - Export each page you need as HTML (full page)

Load each page your require as a docx in Google Chrome (not Safari).

Once loaded export each as a full page (Web page, complete) into the course build directory.

Once saved you can remove the files directory to just leave the HTML page.

## Step 2 - Identify the identifiers marker (To be automated)

On OS X or linux run (from your course directory)

```cat languagefiles/en/export.json | grep \"id\"```

If you have used the authoring tool there is a chance that all the IDs start the same, e.g. 58...

## Step 3 - Run adapt2docx2

Run

```php adapt2docx2.php *inputfile.html* *identifer marker (e.g. 58)* > *outputfile.html*```

## Step 5 - Use Convertio to convert the output files to docx (To be automated)

Go to https://convertio.co/html-docx and upload the output html files from Step 4 to be converted.


# Adapt2Docx (uses translator output)

Convert adapt2 elearning pages into docx for easy client review.

NOTE: It does not do the inverse! So you still have to apply changes by hand, or just use the authoring tool.

## Requirements

* Adapt 2 framework >2.0.11
* php command line

## Step 1 - Export adapt language translation file as json

From your course run:

```grunt translate:export --format="json" --masterLang="en"```

## Step 2 - Export each page you need as HTML (full page)

Load each page your require as a docx in Google Chrome (not Safari).

Once loaded export each as a full page (Web page, complete) into the course build directory.

Once saved you can remove the files directory to just leave the HTML page.

## Step 3 - Identify the identifiers marker (To be automated)

On OS X or linux run (from your course directory)

```cat languagefiles/en/export.json | grep \"id\"```

If you have used the authoring tool there is a chance that all the IDs start the same, e.g. 58...

## Step 4 - Run adapt2docx

Run

```php adapt2docx.php *inputfile.html* *identifer marker (e.g. 58)* > *outputfile.html*```

## Step 5 - Use Convertio to convert the output files to docx (To be automated)

Go to https://convertio.co/html-docx and upload the output html files from Step 4 to be converted.







