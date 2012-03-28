<?php

class HandlersTest extends PHPUnit_Framework_TestCase
{
    public function testIsHandlingString()
    {
        $stringMock = <<<'MOCK'
%% =========================
%% This is a comment, dammit
%% =========================

\input{base}
\input{config}

\begin{document}

\frontmatter
        \tableofcontents

\mainmatter
\chapter{Great scott}
\section{About}
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor dui. Nam aliquam lacus ac elit consequat ut eleifend ipsum placerat. Pellentesque a sem facilisis turpis egestas cursus non ac purus. Donec lacus velit, pretium sed bibendum eget, pharetra non lectus. Maecenas at ligula est. Ut eu rhoncus nibh. Sed enim purus, imperdiet et posuere non, imperdiet id mi. In hac habitasse platea dictumst. Donec euismod, est eget ultrices congue, lorem nisi sagittis nibh, eu pharetra augue felis quis mauris. Morbi viverra bibendum vulputate. Sed in accumsan justo. Proin ut felis sit amet est iaculis ultrices. Pellentesque tincidunt risus in lorem pellentesque sit amet eleifend lorem rutrum. Morbi neque lacus, facilisis et cursus vel, scelerisque vel orci. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam fermentum commodo orci nec consequat.

Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam consequat consequat semper. Curabitur ut neque diam. Sed ullamcorper rhoncus consectetur. Fusce hendrerit nulla sit amet nibh pretium cursus. Nunc imperdiet nibh nec tortor rhoncus dignissim. Integer lacinia fermentum consequat. Pellentesque laoreet dictum mi accumsan faucibus. Mauris augue orci, adipiscing vitae faucibus nec, tristique sit amet augue. Sed volutpat ullamcorper lobortis.

\section{Further details}
In a felis massa. Donec suscipit suscipit magna, eu laoreet nibh rhoncus sagittis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In viverra, sapien ac interdum feugiat, arcu lorem ultricies est, in elementum enim risus ac arcu. Donec a diam eros, at aliquet urna. \textbf{Phasellus nec augue vitae} nibh congue auctor. Vestibulum at enim eget nisl euismod blandit aliquam nec nisi. Mauris sed dignissim elit. Nam consequat volutpat congue. Aliquam mi ante, sodales in tempor convallis, bibendum nec augue. Suspendisse malesuada ligula nec enim dignissim blandit eu a diam. Pellentesque venenatis ipsum eget enim euismod at feugiat odio lacinia. Sed molestie dictum tellus, eget volutpat purus vulputate at.

\begin{itemize}
\item blandit eu a diam
\item purus vulputate at
\item molestie dictum tellus
\end{itemize}

\section{Developing}
Suspendisse malesuada ligula nec enim dignissim blandit eu a diam. Pellentesque venenatis ipsum eget enim euismod at feugiat odio lacinia. Sed molestie dictum tellus, eget volutpat purus vulputate at.

\begin{lstlisting}
<?php
class Car {
	function run() {
	
	}
	
	function stop() {
	
	}
}

$camaro = new Car;
$camaro->run();

\end{lstlisting}
\end{document}

MOCK;
        
        $handler = new LexicalAnalyzer\Handlers\StringHandle($stringMock);
        $this->assertEquals($stringMock, $handler->getData());
        $this->assertEquals(true, $handler->isEndded());
        $this->assertEquals(false, $handler->hasMoreData());
    }
	
    public function testIsHandlingStream()
    {
        $resourceMock = fopen("sample.tex", "r");
        $handler = new LexicalAnalyzer\Handlers\StreamHandle($resourceMock);
        $this->assertEquals("%% =========================\n", $handler->getData());
        $this->assertEquals(true, $handler->isEndded());
        $this->assertEquals(true, $handler->hasMoreData());
    }
}
