# Adapt2Docx2 (uses components file)

Convert adapt2 elearning pages into docx for easy client review.

NOTE: It does not do the inverse! So you still have to apply changes by hand, or just use the authoring tool.

## Requirements

* php command line

## Step 1

Clone this repository and then create a "course" folder inside where it downloaded to.

## Step 2 - Export each page you need as HTML (full page)

Load each page your require as a docx in Google Chrome (not Safari).

Once loaded export each as a full page (Web page, complete) into the course folder you just created

Once saved you can remove the files directory to just leave the HTML page/s.

## Step 3 - Download the courses components file

From your course page you have just saved browse to course/en/components.json and save this file in the course folder also.

Note: Change the language from en if you are not deling with English.

## Step 4 - Identify the identifiers marker (To be automated)

While you still have the components file loaded in your browser search for "_id" and note down what the IDs all start with, e.g. "58...".

## Step 5 - Run adapt2docx2

Open a terminal to where you downloaded adapt2docx2 (not the courses folder) and type

```php adapt2docx2.php *course/inputfile.html* *identifer marker (e.g. 58)* > *outputfile.html*```

## Step 6 - Use Convertio to convert the output files to docx (To be automated)

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







