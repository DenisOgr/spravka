<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output indent="yes" />
	<xsl:template match="item_comments">
		<comments>
			<form method="post">
				<sys_messages />
				<a href="{node/profile}">
					<div class="newline">
						<img src="{node/photo}" width="50" />
					</div>
					<div class="newline">
						<xsl:value-of select="concat(node/first_name,' ',node/last_name)" />
					</div>
				</a>
				<div class="newline">
					Комментарий:
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
