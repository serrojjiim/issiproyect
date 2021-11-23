import pdfkit 
import pathlib
from jinja2 import Environment, FileSystemLoader


class Diploma:
  def __init__(self, _diploma_a_generar, _nombre_diploma,_nombre_alumno,_course,_score,_date):
    self.diploma_a_generar=_diploma_a_generar
    self.nombre_diploma=_nombre_diploma
    self.nombre_alumno=_nombre_alumno
    self.course = _course
    self.score = _score
    self.date = _date
  
  def generate(self):
    env = Environment(loader=FileSystemLoader("./plantillas"))
    template=env.get_template(self.diploma_a_generar)
    usuario ={
        
    'name' : self.nombre_alumno,
    'course':self.course,
    'score' : self.score,
    'date':self.date
    }

    html=template.render(usuario)

    options = {
    'page-size':'A5',
    'margin-top':'0.1in',
    'margin-right':'0.1in',
    'margin-bottom':'0.1in',
    'margin-left':'0.1in',
    'encoding': "UTF-8",
    }

    path = pathlib.Path().resolve() 
    if plataforma=="Windows":
      path_wkhtmltopdf = str(path)+ "\wkhtmltopdf.exe"
    elif plataforma=="Linux":
      path_wkhtmltopdf = str(path)+ "\wkhtmltopdf.deb"

    config = pdfkit.configuration(wkhtmltopdf=path_wkhtmltopdf)
    print("Generando diploma de la plantilla '" +self.diploma_a_generar+"' con nombre '"+self.nombre_diploma+"'")
    pdfkit.from_string(html,self.nombre_diploma,options=options,configuration=config)
    print("Diploma generado correctamente")
    return True

import platform
plataforma = platform.system()
