from peewee import *
import urllib2

mysql_db = MySQLDatabase('openrealstate', user='openrealstate',passwd="gnuubuntu12")
mysql_db.connect()


class Message(Model):
	id = IntegerField(primary_key=True)
	category = TextField()
	message = TextField()
	translation_en = TextField()

	class Meta:
		db_table = "ore_translate_message"
		database = mysql_db






def translate(to_translate, to_langage="auto", langage="auto"):
	'''Return the translation using google translate
	you must shortcut the langage you define (French = fr, English = en, Spanish = es, etc...)
	if you don't define anything it will detect it or use english by default
	Example:
	print(translate("salut tu vas bien?", "en"))
	hello you alright?'''
	agents = {'User-Agent':"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)"}
	before_trans = 'class="t0">'
	link = "http://translate.google.com/m?hl=%s&sl=%s&q=%s" % (to_langage, langage, to_translate.replace(" ", "+"))
	request = urllib2.Request(link, headers=agents)
	page = urllib2.urlopen(request).read()
	result = page[page.find(before_trans)+len(before_trans):]
	result = result.split("<")[0]
	return result



for mensaje in Message.select():
	if not (("}" in mensaje.message) or ("_" in mensaje.message) or ("#" in mensaje.message) or ("<" in mensaje.message) or ("::" in mensaje.message) ):
		#print mensaje.message
		print mensaje.id
		traduccion = translate(mensaje.message, to_langage="es", langage="en")
		print traduccion
		query= Message.update(translation_en=traduccion).where(Message.id == mensaje.id)
		print query.execute()
		print "============================="
		#mensaje.save(force_insert=True)





### INICIO PARTE 2
# delete_query = Document.delete().where(id > 0)
# delete_query.execute()









# archivosDocumentos = glob.glob("nipstxt/idx/c*.txt")
# for file in archivosDocumentos:
#  	f = open(file)
#  	lines = tuple(open(file, 'r'))
#  	print file
#  	f.close()
#  	x = 0
#  	while x < len(lines):

#  		title = ""
#  		authors = ""
#  		id = ""
#  		for n in range(0,3):
#  			if n == 0:
#  				title = lines[x+n].strip()
#  			if n == 1:
#  				authors = lines[x+n].strip()
#  			if n == 2:
#  				id = lines[x+n].strip()

#  		title = title.decode('utf-8', 'ignore')
#  		authors = authors.decode('utf-8', 'ignore')
#  		documento = Document(id=id, year=file[13:15], title= title, authors=authors)
#  		documento.save(force_insert=True)
#  		x +=4

# ### INICIO PARTE 3

# archivosAbstracts = glob.glob("nipstxt/nips*/*.txt")
# for file in archivosAbstracts:
# 	f = open(file)
# 	lines = tuple(open(file, 'r'))
# 	id = int(file[15:19])
# 	year = int(file[12:14])
# 	print file + "ID: "  + str(id) + "Year:" + str(year)
# 	f.close()
# 	x = 0
# 	abstract = False
# 	introduction = False
# 	posAbstract = 0
# 	posIntroduction = 0
# 	while (x < len(lines)):
# 		lineaLimpia = re.sub(r'[^A-Za-z]+', ' ', lines[x].strip())
# 		if ( ("ABSTRACT" in lineaLimpia.upper() ) and (abstract==False) ):
# 			posAbstract = x
# 			abstract = True

# 		if (  (  ("INTRODUCTION" in lineaLimpia.upper() ) or ("INTRODUC ON" in lineaLimpia.decode('utf-8', 'ignore') ) ) and (introduction==False)  and (abstract==True) ):
# 			posIntroduction = x
# 			introduction = True
			
# 		x +=1

# 	if not introduction:
# 		x = posAbstract +1
# 		while (x < len(lines) and (introduction == False)):
# 			if ". \n" in lines[x]:
# 				posIntroduction = x+1
# 				introduction = True
# 			x +=1

# 	x = posAbstract +1
# 	abstract = ""
# 	if not ((posIntroduction - posAbstract)==1 ):
# 		while x<posIntroduction:
# 			abstract = abstract + re.sub(r'[^A-Za-z]+', ' ', lines[x].strip().lower()) + " "
# 			x+=1


# 	tokens = nltk.word_tokenize(abstract)
# 	filtered_words = [w for w in tokens if not w in stopwords.words('english')]
# 	abtract = Abstract(id=id, year=year, abstract=filtered_words)
# 	abtract.save(force_insert=True)
# 	#filtered_words = [w for w in tokens if not w in stopwords.words('english')]
