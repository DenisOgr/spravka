<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output indent="yes" />
	<xsl:template match="item_comments">
		<comments>
			<form method="post">
				<sys_messages />
				<div class="newline">
					Дата:
					<input name="date_add" size="15" type="text">
						<xsl:choose>
							<xsl:when test="node/date_add">
								<xsl:attribute name="value"><xsl:value-of select="node/date_add" /></xsl:attribute>
							</xsl:when>
							<xsl:otherwise>
								<xsl:attribute name="value"><xsl:value-of select="today" /></xsl:attribute>
							</xsl:otherwise>
						</xsl:choose>
					</input>
				</div>

				<div class="newline">
					Имя
					<span class="red">*</span>
					:
					<input name="name" value="{node/name}" size="15" type="text" />
				</div>

				<div class="newline">
					Комментарий:
					<span class="red">*</span>
					:
					<div class="tarea">
						<textarea style="width:100%;" class="no_editor" name="text" rows="5">
							<xsl:value-of select="node/text" />
						</textarea>
					</div>
				</div>

				<div>
					<input name="save_item" value="Сохранить" class="submit" type="submit" />
					<input name="cancel" value="Отмена" class="submit" type="submit" />
				</div>

			</form>
		</comments>
	</xsl:template>
</xsl:stylesheet>
