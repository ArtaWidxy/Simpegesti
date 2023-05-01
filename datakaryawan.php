=head1 NAME

XML::LibXML::Parser - Parsing XML Data with XML::LibXML

=head1 SYNOPSIS



  use XML::LibXML '1.70';

  # Parser constructor

  $parser = XML::LibXML->new();
  $parser = XML::LibXML->new(option=>value, ...);
  $parser = XML::LibXML->new({option=>value, ...});

  # Parsing XML

  $dom = XML::LibXML->load_xml(
      location => $file_or_url
      # parser options ...
    );
  $dom = XML::LibXML->load_xml(
      string => $xml_string
      # parser options ...
    );
  $dom = XML::LibXML->load_xml(
      string => (\$xml_string)
      # parser options ...
    );
  $dom = XML::LibXML->load_xml({
      IO => $perl_file_handle
      # parser options ...
    );
  $dom = $parser->load_xml(...);

  # Parsing HTML

  $dom = XML::LibXML->load_html(...);
  $dom = $parser->load_html(...);

  # Parsing well-balanced XML chunks

  $fragment = $parser->parse_balanced_chunk( $wbxmlstring, $encoding );

  # Processing XInclude

  $parser->process_xincludes( $doc );
  $parser->processXIncludes( $doc );

  # Old-style parser interfaces

  $doc = $parser->parse_file( $xmlfilename );
  $doc = $parser->parse_fh( $io_fh );
  $doc = $parser->parse_string( $xmlstring);
  $doc = $parser->parse_html_file( $htmlfile, \%opts );
  $doc = $parser->parse_html_fh( $io_fh, \%opts );
  $doc = $parser->parse_html_string( $htmlstring, \%opts );

  # Push parser

  $parser->parse_chunk($string, $terminate);
  $parser->init_push();
  $parser->push(@data);
  $doc = $parser->finish_push( $recover );

  # Set/query parser options

  $parser->option_exists($name);
  $parser->get_option($name);
  $parser->set_option($name,$value);
  $parser->set_options({$name=>$value,...});

  # XML catalogs

  $parser->load_catalog( $catalog_file );

=head1 PARSING

An XML document is read into a data structure such as a DOM tree by a piece of
software, called a parser. XML::LibXML currently provides four different parser
interfaces:


=over 4

=item *

A DOM Pull-Parser



=item *

A DOM Push-Parser



=item *

A SAX Parser



=item *

A DOM based SAX Parser.



=back


=head2 Creating a Parser Instance

XML::LibXML provides an OO interface to the libxml2 parser functions. Thus you
have to create a parser instance before you can parse any XML data.

=over 4

=item new


  $parser = XML::LibXML->new();
  $parser = XML::LibXML->new(option=>value, ...);
  $parser = XML::LibXML->new({option=>value, ...});

Create a new XML and HTML parser instance. Each parser instance holds default
values for various parser options. Optionally, one can pass a hash reference or
a list of option => value pairs to set a different default set of options.
Unless specified otherwise, the options C<<<<<< load_ext_dtd >>>>>>, and C<<<<<< expand_entities >>>>>> are set to 1. See L<<<<<< Parser Options >>>>>> for a list of libxml2 parser's options.



=back


=head2 DOM Parser

One of the common parser interfaces of XML::LibXML is the DOM parser. This
parser reads XML data into a DOM like data structure, so each tag can get
accessed and transformed.

XML::LibXML's DOM parser is not only capable to parse XML data, but also
(strict) HTML files. There are three ways to parse documents - as a string, as
a Perl filehandle, or as a filename/URL. The return value from each is a L<<<<<< XML::LibXML::Document >>>>>> object, which is a DOM object.

All of the functions listed below will throw an exception if the document is
invalid. To prevent this causing your program exiting, wrap the call in an
eval{} block

=over 4

=item load_xml


  $dom = XML::LibXML->load_xml(
      location => $file_or_url
      # parser options ...
    );
  $dom = XML::LibXML->load_xml(
      string => $xml_string
      # parser options ...
    );
  $dom = XML::LibXML->load_xml(
      string => (\$xml_string)
      # parser options ...
    );
  $dom = XML::LibXML->load_xml({
      IO => $perl_file_handle
      # parser options ...
    );
  $dom = $parser->load_xml(...);


This function is available since XML::LibXML 1.70. It provides easy to use
interface to the XML parser that parses given file (or non-HTTPS URL), string,
or input stream to a DOM tree. The arguments can be passed in a HASH reference
or as name => value pairs. The function can be called as a class method or an
object method. In both cases it internally creates a new parser instance
passing the specified parser options; if called as an object method, it clones
the original parser (preserving its settings) and additionally applies the
specified options to the new parser. See the constructor C<<<<<< new >>>>>> and L<<<<<< Parser Options >>>>>> for more information.

Note that, due to a limitation in the underlying libxml2 library, this call
does not recognize HTTPS-based URLs. (It will treat an HTTPS URL as a filename,
likely throwing a "No such file or directory" exception.)


=item load_html


  $dom = XML::LibXML->load_html(...);
  $dom = $parser->load_html(...);


This function is available since XML::LibXML 1.70. It has the same usage as C<<<<<< load_xml >>>>>>, providing interface to the HTML parser. See C<<<<<< load_xml >>>>>> for more information.



=back

Parsing HTML may cause problems, especially if the ampersand ('&') is used.
This is a common problem if HTML code is parsed that contains links to
CGI-scripts. Such links cause the parser to throw errors. In such cases libxml2
still parses the entire document as there was no error, but the error causes
XML::LibXML to stop the parsing process. However, the document is not lost.
Such HTML documents should be parsed using the I<<<<<< recover >>>>>> flag. By default recovering is deactivated.

The functions described above are implemented to parse well formed documents.
In some cases a program gets well balanced XML instead of well formed documents
(e.g. an XML fragment from a database). With XML::LibXML it is not required to
wrap such fragments in the code, because XML::LibXML is capable even to parse
well balanced XML fragments.

=over 4

=item parse_balanced_chunk

  $fragment = $parser->parse_balanced_chunk( $wbxmlstring, $encoding );

This function parses a well balanced XML string into a L<<<<<< XML::LibXML::DocumentFragment >>>>>>. The first arguments contains the input string, the optional second argument
can be used to specify character encoding of the input (UTF-8 is assumed by
default).


=item parse_xml_chunk

This is the old name of parse_balanced_chunk(). Because it may causes confusion
with the push parser interface, this function should not be used anymore.



=back

By default XML::LibXML does not process XInclude tags within an XML Document
(see options section below). XML::LibXML allows one to post-process a document
to expand XInclude tags.

=over 4

=item process_xincludes

  $parser->process_xincludes( $doc );

After a document is parsed into a DOM structure, you may want to expand the
documents XInclude tags. This function processes the given document structure
and expands all XInclude tags (or throws an error) by using the flags and
callbacks of the given parser instance.

Note that the resulting Tree contains some extra nodes (of type
XML_XINCLUDE_START and XML_XINCLUDE_END) after successfully processing the
document. These nodes indicate where data was included into the original tree.
if the document is serialized, these extra nodes will not show up.

Remember: A Document with processed XIncludes differs from the original
document after serialization, because the original XInclude tags will not get
restored!

If the parser flag "expand_xincludes" is set to 1, you need not to post process
the parsed document.


=item processXIncludes

  $parser->processXIncludes( $doc );

This is an alias to process_xincludes, but through a JAVA like function name.


=item parse_file

  $doc = $parser->parse_file( $xmlfilename );

This function parses an XML document from a file or network; $xmlfilename can
be either a filename or a (non-HTTPS) URL. Note that for parsing files, this
function is the fastest choice, about 6-8 times faster then parse_fh().


=item parse_fh

  $doc = $parser->parse_fh( $io_fh );

parse_fh() parses a IOREF or a subclass of IO::Handle.

Because the data comes from an open handle, libxml2's parser does not know
about the base URI of the document. To set the base URI one should use
parse_fh() as follows:



  my $doc = $parser->parse_fh( $io_fh, $baseuri );


=item parse_string

  $doc = $parser->parse_string( $xmlstring);

This function is similar to parse_fh(), but it parses an XML document that is
available as a single string in memory, or alternatively as a reference to a
scalar containing a string. Again, you can pass an optional base URI to the
function.



  my $doc = $parser->parse_string( $xmlstring, $baseuri );
  my $doc = $parser->parse_string(\$xmlstring, $baseuri);


=item parse_html_file

  $doc = $parser->parse_html_file( $htmlfile, \%opts );

Similar to parse_file() but parses HTML (strict) documents; $htmlfile can be
filename or (non-HTTPS) URL.

An optional second argument can be used to pass some options to the HTML parser
as a HASH reference. See options labeled with HTML in L<<<<<< Parser Options >>>>>>.


=item parse_html_fh

  $doc = $parser->parse_html_fh( $io_fh, \%opts );

Similar to parse_fh() but parses HTML (strict) streams.

An optional second argument can be used to pass some options to the HTML parser
as a HASH reference. See options labeled with HTML in L<<<<<< Parser Options >>>>>>.

Note: encoding option may not work correctly with this function in libxml2 <
2.6.27 if the HTML file declares charset using a META tag.


=item parse_html_string

  $doc = $parser->parse_html_string( $htmlstring, \%opts );

Similar to parse_string() but parses HTML (strict) strings.

An optional second argument can be used to pass some options to the HTML parser
as a HASH reference. See options labeled with HTML in L<<<<<< Parser Options >>>>>>.



=back


=head2 Push Parser

XML::LibXML provides a push parser interface. Rather than pulling the data from
a given source the push parser waits for the data to be pushed into it.

This allows one to parse large documents without waiting for the parser to
finish. The interface is especially useful if a program needs to pre-process
the incoming pieces of XML (e.g. to detect document boundaries).

While XML::LibXML parse_*() functions force the data to be a well-formed XML,
the push parser will take any arbitrary string that contains some XML data. The
only requirement is that all the pushed strings are together a well formed
document. With the push parser interface a program can interrupt the parsing
process as required, where the parse_*() functions give not enough flexibility.

Different to the pull parser implemented in parse_fh() or parse_file(), the
push parser is not able to find out about the documents end itself. Thus the
calling program needs to indicate explicitly when the parsing is done.

In XML::LibXML this is done by a single function:

=over 4

=item parse_chunk

  $parser->parse_chunk($string, $terminate);

parse_chunk() tries to parse a given chunk of data, which isn't necessarily
well balanced data. The function takes two parameters: The chunk of data as a
string and optional a termination flag. If the termination flag is set to a
true value (e.g. 1), the parsing will be stopped and the resulting document
will be returned as the following example describes:



  my $parser = XML::LibXML->new;
  for my $string ( "<", "foo", ' bar="hello world"', "/>") {
       $parser->parse_chunk( $string );
  }
  my $doc = $parser->parse_chunk("", 1); # terminate the parsing



=back

Internally XML::LibXML provides three functions that control the push parser
process:

=over 4

=item init_push

  $parser->init_push();

Initializes the push parser.


=item push

  $parser->push(@data);

This function pushes the data stored inside the array to libxml2's parser. Each
entry in @data must be a normal scalar! This method can be called repeatedly.


=item finish_push

  $doc = $parser->finish_push( $recover );

This function returns the result of the parsing process. If this function is
called without a parameter it will complain about non well-formed documents. If
$restore is 1, the push parser can be used to restore broken or non well formed
(XML) documents as the following example shows:



  eval {
      $parser->push( "<foo>", "bar" );
      $doc = $parser->finish_push();    # will report broken XML
  };
  if ( $@ ) {
     # ...
  }

This can be annoying if the closing tag is missed by accident. The following
code will restore the document:



  eval {
      $parser->push( "<foo>", "bar" );
      $doc = $parser->finish_push(1);   # will return the data parsed
                                        # unless an error happened
  };

  print $doc->toString(); # returns "<foo>bar</foo>"

Of course finish_push() will return nothing if there was no data pushed to the
parser before.



=back


=head2 Pull Parser (Reader)

XML::LibXML also provides a pull-parser interface similar to the XmlReader
interface in .NET. This interface is almost streaming, and is usually faster
and simpler to use than SAX. See L<<<<<< XML::LibXML::Reader >>>>>>.


=head2 Direct SAX Parser

XML::LibXML provides a direct SAX parser in the L<<<<<< XML::LibXML::SAX >>>>>> module.


=head2 DOM based SAX Parser

XML::LibXML also provides a DOM based SAX parser. The SAX parser is defined in
the module XML::LibXML::SAX::Parser. As it is not a stream based parser, it
parses documents into a DOM and traverses the DOM tree instead.

The API of this parser is exactly the same as any other Perl SAX2 parser. See
XML::SAX::Intro for details.

Aside from the regular parsing methods, you can access the DOM tree traverser
directly, using the generate() method:



  my $doc = build_yourself_a_document();
  my $saxparser = $XML::LibXML::SAX::Parser->new( ... );
  $parser->generate( $doc );

This is useful for serializing DOM trees, for example that you might have done
prior processing on, or that you have as a result of XSLT processing.

I<<<<<< WARNING >>>>>>

This is NOT a streaming SAX parser. As I said above, this parser reads the
entire document into a DOM and serialises it. Some people couldn't read that in
the paragraph above so I've added this warning. If you want a streaming SAX
parser look at the L<<<<<< XML::LibXML::SAX >>>>>> man page


=head1 SERIALIZATION

XML::LibXML provides some functions to serialize nodes and documents. The
serialization functions are described on the L<<<<<< XML::LibXML::Node >>>>>> manpage or the L<<<<<< XML::LibXML::Document >>>>>> manpage. XML::LibXML checks three global flags that alter the serialization
process:


=over 4

=item *

skipXMLDeclaration



=item *

skipDTD



=item *

setTagCompression



=back

of that three functions only setTagCompression is available for all
serialization functions.

Because XML::LibXML does these flags not itself, one has to define them locally
as the following example shows:



  local $XML::LibXML::skipXMLDeclaration = 1;
  local $XML::LibXML::skipDTD = 1;
  local $XML::LibXML::setTagCompression = 1;

If skipXMLDeclaration is defined and not '0', the XML declaration is omitted
during serialization.

If skipDTD is defined and not '0', an existing DTD would not be serialized with
the document.

If setTagCompression is defined and not '0' empty tags are displayed as open
and closing tags rather than the shortcut. For example the empty tag I<<<<<< foo >>>>>> will be rendered as I<<<<<< E<lt>fooE<gt>E<lt>/fooE<gt> >>>>>> rather than I<<<<<< E<lt>foo/E<gt> >>>>>>.


=head1 PARSER OPTIONS

Handling of libxml2 parser options has been unified and improved in XML::LibXML
1.70. You can now set default options for a particular parser instance by
passing them to the constructor as C<<<<<< XML::LibXML-E<gt>new({name=E<gt>value, ...}) >>>>>> or C<<<<<< XML::LibXML-E<gt>new(name=E<gt>value,...) >>>>>>. The options can be queried and changed using the following methods (pre-1.70
interfaces such as C<<<<<< $parser-E<gt>load_ext_dtd(0) >>>>>> also exist, see below):

=over 4

=item option_exists

  $parser->option_exists($name);

Returns 1 if the current XML::LibXML version supports the option C<<<<<< $name >>>>>>, otherwise returns 0 (note that this does not necessarily mean that the option
is supported by the underlying libxml2 library).


=item get_option

  $parser->get_option($name);

Returns the current value of the parser option C<<<<<< $name >>>>>>.


=item set_option

  $parser->set_option($name,$value);

Sets option C<<<<<< $name >>>>>> to value C<<<<<< $value >>>>>>.


=item set_options

  $parser->set_options({$name=>$value,...});

Sets multiple parsing options at once.



=back

IMPORTANT NOTE: This documentation reflects the parser flags available in
libxml2 2.7.3. Some options have no effect if an older version of libxml2 is
used.

Each of the flags listed below is labeled

=over 4

=item /parser/

if it can be used with a C<<<<<< XML::LibXML >>>>>> parser object (i.e. passed to C<<<<<< XML::LibXML-E<gt>new >>>>>>, C<<<<<< XML::LibXML-E<gt>set_option >>>>>>, etc.)


=item /html/

if it can be used passed to the C<<<<<< parse_html_* >>>>>> methods


=item /reader/

if it can be used with the C<<<<<< XML::LibXML::Reader >>>>>>.



=back

Unless specified otherwise, the default for boolean valued options is 0
(false).

The available options are:

=over 4

=item URI

/parser, html, reader/

In case of parsing strings or file handles, XML::LibXML doesn't know about the
base uri of the document. To make relative references such as XIncludes work,
one has to set a base URI, that is then used for the parsed document.


=item line_numbers

/parser, html, reader/

If this option is activated, libxml2 will store the line number of each element
node in the parsed document. The line number can be obtained using the C<<<<<< line_number() >>>>>> method of the C<<<<<< XML::LibXML::Node >>>>>> class (for non-element nodes this may report the line number of the containing
element). The line numbers are also used for reporting positions of validation
errors.

IMPORTANT: Due to limitations in the libxml2 library line numbers greater than
65535 will be returned as 65535. Unfortunately, this is a long and sad story,
please see L<<<<<< http://bugzilla.gnome.org/show_bug.cgi?id=325533 >>>>>> for more details.


=item encoding

/html/

character encoding of the input


=item recover

/parser, html, reader/

recover from errors; possible values are 0, 1, and 2

A true value turns on recovery mode which allows one to parse broken XML or
HTML data. The recovery mode allows the parser to return the successfully
parsed portion of the input document. This is useful for almost well-formed
documents, where for example a closing tag is missing somewhere. Still,
XML::LibXML will only parse until the first fatal (non-recoverable) error
occurs, reporting recoverable parsing errors as warnings. To suppress even
these warnings, use recover=>2.

Note that validation is switched off automatically in recovery mode.


=item expand_entities

/parser, reader/

substitute entities; possible values are 0 and 1; default is 1

Note that although this flag disables entity substitution, it does not prevent
the parser from loading external entities; when substitution of an external
entity is disabled, the entity will be represented in the document tree by an
XML_ENTITY_REF_NODE node whose subtree will be the content obtained by parsing
the external resource; Although this nesting is visible from the DOM it is
transparent to XPath data model, so it is possible to match nodes in an
unexpanded entity by the same XPath expression as if the entity were expanded.
See also ext_ent_handler.


=item ext_ent_handler

/parser/

Provide a custom external entity 