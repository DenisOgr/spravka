<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output indent="yes" />

	<xsl:template match="comments">
		<script type="text/javascript" src="/modules/comments/comments.js" />
		<script src="http://ulogin.ru/js/ulogin.js"/>
		<div id="comments" data-item="{get/item}">
		<input type="hidden" id="item" value="{get/item}"/>		
		<h2>Комментарии</h2>		
			<ul>
				<xsl:for-each select="item">
					<li>
						<div class="datetime">
							<xsl:value-of select="date_add" />
						</div>
						<a href="{profile}">
							<b>
								<xsl:value-of select="concat(first_name,' ', last_name)" />
							</b>
							<img src="{photo}" class="photo" />
						</a>
						<div class="text">
							<xsl:value-of select="text" />
						</div>
					</li>
				</xsl:for-each>
			</ul>
			<br class="clear" />
			<div id="terms">
				<xsl:choose>
					<xsl:when test="user">
						<b>
							<xsl:value-of select="concat(user/first_name,' ', user/last_name)" />
						</b>
						<a href="#" id="logout">Выйти</a>
						<form method="post">
							<input type="hidden" name="id_user" value="{user/id}" />
							<input name="id_item" type="hidden" value="{//requests/get/ITEM}" />
							<img src="{user/photo}" class="photo" />
							<textarea id="comment_text" name="text"></textarea>
							<br />
							<input type="submit" name="save_message" value="Отправить" />
						</form>
					</xsl:when>
					<xsl:otherwise>
						<div id="t_message">Чтобы оставить отзыв, необходимо войти</div>
						<div id="uLogin"
							x-ulogin-params="display=small;fields=first_name,last_name,photo;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter,livejournal,yandex;hidden=;redirect_uri=http%3A%2F%2Fspravka-melitopol.info/ulogin_xd.html;callback=social_login"></div>
					</xsl:otherwise>
				</xsl:choose>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>
