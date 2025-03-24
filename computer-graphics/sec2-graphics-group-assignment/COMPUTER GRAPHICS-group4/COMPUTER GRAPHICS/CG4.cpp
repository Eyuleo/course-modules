#include <GL/glut.h>

void display() {
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();

    // Draw the flag of Germany
    // Black band
    glColor3f(0.0, 0.0, 0.0); // Black color
    glBegin(GL_QUADS);
    glVertex2f(-1.0, 1.0);
    glVertex2f(1.0, 1.0);
    glVertex2f(1.0, 0.33);
    glVertex2f(-1.0, 0.33);
    glEnd();

    // Red band
    glColor3f(1.0, 0.0, 0.0); // Red color
    glBegin(GL_QUADS);
    glVertex2f(-1.0, 0.33);
    glVertex2f(1.0, 0.33);
    glVertex2f(1.0, -0.33);
    glVertex2f(-1.0, -0.33);
    glEnd();

    // Gold (Yellow) band
    glColor3f(1.0, 0.84, 0.0); // Gold (Yellow) color
    glBegin(GL_QUADS);
    glVertex2f(-1.0, -0.33);
    glVertex2f(1.0, -0.33);
    glVertex2f(1.0, -1.0);
    glVertex2f(-1.0, -1.0);
    glEnd();

    glutSwapBuffers();
}

int main(int argc, char** argv) {
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_RGB | GLUT_DOUBLE | GLUT_DEPTH);
    glutCreateWindow("Flag of Germany");
    glutDisplayFunc(display);
    glEnable(GL_DEPTH_TEST);

    glutMainLoop();

    return 0;
}