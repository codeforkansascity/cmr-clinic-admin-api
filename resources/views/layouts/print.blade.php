<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body { font-family: Helvetica, sans-serif; font-size: 14px; }
            table { border-collapse: collapse; width: 100%; border: 0; }
            table, tr, th, td { page-break-inside: avoid; }
            th { background-color: #000; color: #fff; padding: 5px; vertical-align: top; border-bottom: 1px solid #000; border-left: 1px solid #000; }
            td { padding: 5px; vertical-align: top; border-bottom: 1px solid #aaa; border-left: 1px solid #aaa; }
            tr th:first-child, tr td:first-child { border-left: 1px solid #000; }
            tr th:last-child, tr td:last-child { border-right: 1px solid #000; }
            tr:last-child td { border-bottom: 1px solid #000; }
            tr:nth-child(odd) td { background-color: #eee; }
            @yield('additional-css')
        </style>
    </head>
    <body>
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                @yield('table-headings-row')
            </thead>
            <tbody>
                @yield('table-data-rows')
            </tbody>
        </table>
        <script type="text/php">
            $font = $fontMetrics->get_font('helvetica', 'normal');
            $font_bold = $fontMetrics->get_font('helvetica', 'bold');
            $size = 11;
            $size_large = 16;

            // Header title:
            $title = '@yield('page-title')';
            $y = 8;
            $x = ($pdf->get_width() - $fontMetrics->get_text_width($title, $font_bold, $size_large)) / 2;
            $pdf->page_text($x, $y, $title, $font_bold, $size_large);

            // Header date/time:
            $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
            $currentDate = $currentDate->format('F j, Y g:ia');
            $y = 11;
            $x = $pdf->get_width() - $fontMetrics->get_text_width($currentDate, $font, $size);
            $x -= 16; // Adjust
            $pdf->page_text($x, $y, $currentDate, $font, $size);

            // Footer:
            $pages = 'Page {PAGE_NUM} of {PAGE_COUNT}';
            $y = $pdf->get_height();
            $y -= 23; // Adjust
            $x = $pdf->get_width() - $fontMetrics->get_text_width('Page 1 of 10', $font, $size);
            $x -= 10; // Adjust
            $pdf->page_text($x, $y, $pages, $font, $size);

            @yield('additional-php')
        </script>
    </body>
</html>