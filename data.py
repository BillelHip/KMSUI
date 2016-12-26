from tinydb import TinyDB, Query

class DB:

    db = TinyDB('db.json')
    table_teacher = db.table('Teacher')
    table_parent = db.table('Parent')
    table_student = db.table('Student')
    table_event = db.table('Event')

    def __init__(self):
        q = Query()
        teacher = self.table_teacher.search(q.TeacherID==0)
        if len(teacher)==0:
            self.table_teacher.insert({
                'ID': 0,
                'FullName': 'Super Admin',
                'Username': 'admin',
                'Password': 'ADMIN',
                'HeadTeacher': True
            })
        elif len(teacher[0].keys())<5:
            self.table_teacher.update({
                'ID': 0,
                'FullName': 'Super Admin',
                'Username': 'admin',
                'Password': 'ADMIN',
                'HeadTeacher': True
            }, q.ID==0)

    def teacher_authen(self,username, password):
        q = Query()
        teacher = self.table_teacher.search((q.Username == username) & (q.Password == password))
        ret = {}
        if len(teacher):
            ret = teacher

        return ret

    def parent_authen(self, mykidID, parentIC):
        q = Query()
        parent = self.table_parent.search((q.StudentID == mykidID) & (q.ParentID == parentIC))
        ret = {}
        if len(parent):
            ret = parent

        return ret

    def get_events(self):
        return self.table_event.all()

    def add_events(self, subject, date, description, year4, year5, year6):
        id = len(self.table_event.all())+1
        self.table_event.insert(
            {
                "EventID": id,
                "Description": description,
                "Year4": year4,
                "Year5": year5,
                "Year6": year6,
                "Date": date,
                "Subject": subject
            }
        )
        return True



