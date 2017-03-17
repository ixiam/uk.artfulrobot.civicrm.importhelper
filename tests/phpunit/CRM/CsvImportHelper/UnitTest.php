<?php
/**
 * @file
 * These are proper unit tests that do not depend on any external services.
 */

//require __DIR__ . '/../../../../CRM/CsvImportHelper.php';

class CRM_CsvImportHelper_UnitTest extends \PHPUnit_Framework_TestCase {

  /**
   * Empty input should result in an empty array (no rows).
   */
  public function testParseCsvEmpty() {
    $csv = '';
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([], $parsed);
  }
  /**
   * Parse a single non quoted word.
   */
  public function testParseCsvSimpleNonQuotedWord() {
    $csv = 'field';
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['field']], $parsed);
  }
  /**
   * Parse a single quoted word.
   */
  public function testParseCsvSimpleQuotedWord() {
    $csv = '"field"';
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['field']], $parsed);
  }
  /**
   * Parse a single quoted word including "" style quotes.
   */
  public function testParseCsvSimpleQuotedWordWithQuotes() {
    $csv = '"Rich said ""hi"""';
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['Rich said "hi"']], $parsed);
  }
  /**
   * Parse a single quoted word including "" style quotes.
   */
  public function testParseCsvSimpleQuotedWordWithQuotes2() {
    $csv = '"Rich said ""hi"", which was nice"';
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['Rich said "hi", which was nice']], $parsed);
  }
  /**
   *
   */
  public function testParseCsvSimpleMultipleFields() {
    $csv = 'unquoted string,123,"quoted string",another,"Rich said ""Hi"", which was nice"';
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['unquoted string', '123', 'quoted string', 'another', 'Rich said "Hi", which was nice']], $parsed);
  }
  /**
   *
   */
  public function testParseCsvMultiLineSimple() {
    $csv = "line1\nline2";
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['line1'], ['line2']], $parsed);
  }
  /**
   *
   */
  public function testParseCsvMultiLineSimpleWithEOLAtEOF() {
    $csv = "line1\nline2\n";
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['line1'], ['line2']], $parsed);
  }
  /**
   *
   */
  public function testParseCsvMultiLineQuoted() {
    $csv = "\"line1\"\n\"line2\"";
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['line1'], ['line2']], $parsed);
  }
  /**
   *
   */
  public function testParseCsvMultiLineQuotedWithQuotes() {
    $csv = "\"Rich says \"\"Hi\"\"\"\n\"\"\"Goodbye\"\", said Wilma\"";
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([['Rich says "Hi"'], ['"Goodbye", said Wilma']], $parsed);
  }
  /**
   *
   */
  public function testParseCsvMultiLineQuotedWithQuotesAndNewlines() {
    $csv = "\"Rich says\n\"\"Hi\"\"\"\n\"\"\"Goodbye\"\",\nsaid Wilma\"";
    $parsed = CRM_CsvImportHelper::parseCsvString($csv);
    $this->assertEquals([["Rich says\n\"Hi\""], ["\"Goodbye\",\nsaid Wilma"]], $parsed);
  }
}
