#include <GL/glut.h>

void display() {
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();

    // Draw horizontal stripes - Green, Yellow, Red
    glBegin(GL_QUADS);
    // Green stripe
    glColor3f(0.0, 0.5, 0.0); // Green color
    glVertex2f(-1.0, 0.5);
    glVertex2f(1.0, 0.5);
    glVertex2f(1.0, 0.0);
    glVertex2f(-1.0, 0.0);

    // Yellow stripe
    glColor3f(1.0, 1.0, 0.0); // Yellow color
    glVertex2f(-1.0, 0.0);
    glVertex2f(1.0, 0.0);
    glVertex2f(1.0, -0.5);
    glVertex2f(-1.0, -0.5);

    // Red stripe
    glColor3f(1.0, 0.0, 0.0); // Red color
    glVertex2f(-1.0, -0.5);
    glVertex2f(1.0, -0.5);
    glVertex2f(1.0, -1.0);
    glVertex2f(-1.0, -1.0);
    glEnd();

    // Draw the blue circle with a yellow star
    // Add code to draw the blue circle with a yellow star

    glutSwapBuffers();
}

int main(int argc, char** argv) {
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_RGB | GLUT_DOUBLE | GLUT_DEPTH);
    glutCreateWindow("Flag of Ethiopia");
    glutDisplayFunc(display);
    glEnable(GL_DEPTH_TEST);

    glutMainLoop();

    return 0;
}