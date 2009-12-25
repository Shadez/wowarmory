<div class="module-block-left">
{{if $armoryNews}}
<div class="armory-firsts">
<div class="module">
<h1>{{#armory_news_title#}}</h1>
{{foreach from=$armoryNews item=news}}
<div class="module-lite news_feed">
<div class="news_upd">
<img class="p news_icon" src="images/news_news.png" /><div>
<b style="color:white">{{$news.title}}</b>
		<span class="timestamp-news-{{$news.id}}" style="display:none">{{$news.date}}+00:00</span>
</div>
<div>{{$news.text}}
</div>
</div>
<script type="text/javascript">
						L10n.formatTimestamps("span.timestamp-news-{{$news.id}}", {
			withinHour: "{0} {{#armory_timeformat_1#}}",
			withinHourSingular: "{0} {{#armory_timeformat_2#}}",
			withinDay: "{0} {{#armory_timeformat_3#}}",
			withinDaySingular: "{0} {{#armory_timeformat_4#}}",
			today: "{{#armory_timeformat_5#}} {0}",
			yesterday: "{{#armory_timeformat_6#}}",
			date: "d.M.yyyy"
		});
					</script>
</div>
{{/foreach}}
</div>
</div>
{{/if}}
<div class="rinfo">
<div class="module">
<h1>{{#armory_faq_header#}}</h1>
<div class="faq">
<div class="rlbox2">
<div class="module-lite">
<div class="faq-links">
<ol>
<li>
<a class="faq-off" href="javascript:faqSwitch(1);" id="faqlink1">{{#armory_faq_q1#}}</a>
</li>
<li>
<a class="faq-off" href="javascript:faqSwitch(2);" id="faqlink2">{{#armory_faq_q2#}}</a>
</li>
<li>
<a class="faq-off" href="javascript:faqSwitch(3);" id="faqlink3">{{#armory_faq_q3#}}</a>
</li>
<li>
<a class="faq-off" href="javascript:faqSwitch(4);" id="faqlink4">{{#armory_faq_q4#}}</a>
</li>
<li>
<a class="faq-off" href="javascript:faqSwitch(5);" id="faqlink5">{{#armory_faq_q5#}}</a>
</li>
<li>
<a class="faq-off" href="javascript:faqSwitch(6);" id="faqlink6">{{#armory_faq_q6#}}</a>
</li>
<li>
<a class="faq-off" href="javascript:faqSwitch(7);" id="faqlink7">{{#armory_faq_q7#}}</a>
</li>
</ol>
</div>
</div>
<div class="module-lite" style="margin-top:5px">
<div class="speak-bubble">
<div id="faq1" style="display:none;">
<h2>{{#armory_faq_q1#}}</h2>
			{{#armory_faq_a1#}}
		</div>
<div id="faq2" style="display:none;">
<h2>{{#armory_faq_q2#}}</h2>
			{{#armory_faq_a2#}}
        </div>
<div id="faq3" style="display:none;">
<h2>{{#armory_faq_q3#}}</h2>
			{{#armory_faq_a3#}}
		</div>
<div id="faq4" style="display:none;">
<h2>{{#armory_faq_q4#}}</h2>
			{{#armory_faq_a4#}}
		</div>
<div id="faq5" style="display:none;">
<h2>{{#armory_faq_q5#}}</h2>
			{{#armory_faq_a5#}}
		</div>
<div id="faq6" style="display:none;">
<h2>{{#armory_faq_q6#}}</h2>
			{{#armory_faq_a6#}}
		</div>
<div id="faq7" style="display:none;">
<h2>{{#armory_faq_q7#}}</h2>
			{{#armory_faq_a7#}}
		</div>
<div class="faq-desc">
<div id="faq-container"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
