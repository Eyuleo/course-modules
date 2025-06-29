#include <GL/glut.h>
#include <cmath>

void display() {
	glClear(GL_COLOR_BUFFER_BIT);
	
	// Blue Rectangle
	glColor3f(0.23921568627450981,0.396078431372549,0.5764705882352941); // Set color to blue (RGB: 0, 0, 1)
	glBegin(GL_QUADS);
	glVertex2f(-0.77, -6.0); // Bottom-left corner
	glVertex2f(0.77, -6.0);  // Bottom-right corner
	glVertex2f(0.77, 6.0);   // Top-right corner
	glVertex2f(-0.77, 6.0);  // Top-left corner
	glEnd();
	
	// Brown Rectangle Inside
	glColor3f(0.784313725490,0.4745098039215686,0.16470588235294117); // Set color to brown (RGB: 0.6, 0.3, 0.0)
	glBegin(GL_QUADS);
	// Calculate dimensions based on blue rectangle's height and width
	float brownRectWidth = 0.75 * 2 * 3 / 4; // 3/4 of blue rectangle's width
	float brownRectHeight = 4.0 * 2 * 0.1;   // 10% of blue rectangle's height
	glVertex2f(-brownRectWidth / 2.9, -4.0); // Bottom-left corner
	glVertex2f(brownRectWidth / 2.9, -4.0);  // Bottom-right corner
	glVertex2f(brownRectWidth / 2.9, -4.0 + brownRectHeight);   // Top-right corner
	glVertex2f(-brownRectWidth / 2.9, -4.0 + brownRectHeight);  // Top-left corner
	glEnd();
	
	// Set the color to red
	glColor3f(1.0f, 0.0f, 0.0f);
	
	// Draw a circle (inner red)
	glLineWidth(4.0); // Increase border thickness
	glBegin(GL_LINE_LOOP);
	float inner_red_radius = 0.55f; // Inner red circle radius
	for (int i = 0; i < 360; ++i) {
		float angle = i * 3.14159f / 180;
		float x = inner_red_radius * cos(angle); // Adjust x-coordinate to fit within the rectangle
		float y = 5 * inner_red_radius * sin(angle); // Adjust y-coordinate to fit within the rectangle and increase height by 5x
		glVertex2f(x, y);
	}
	glEnd();
	
	// Set the color to yellow
	glColor3f(1.0f, 1.0f, 0.0f);
	
	// Draw a smaller yellow circle inside the red circle
	glBegin(GL_LINE_LOOP);
	float smaller_yellow_radius = 0.95f * inner_red_radius; // 95% of the original red circle radius
	for (int i = 0; i < 360; ++i) {
		float angle = i * 3.14159f / 180;
		float x = smaller_yellow_radius * cos(angle); // Adjust x-coordinate to fit within the rectangle
		float y = 5 * smaller_yellow_radius * sin(angle); // Adjust y-coordinate to fit within the rectangle and increase height by 5x
		glVertex2f(x, y);
	}
	glEnd();
	
	// Set the color to black
	glColor3f(0.0f, 0.0f, 0.0f);
	
	// Draw a smaller black circle inside the yellow circle
	glBegin(GL_LINE_LOOP);
	float smaller_black_radius = 0.95f * smaller_yellow_radius; // 95% of the yellow circle radius
	for (int i = 0; i < 360; ++i) {
		float angle = i * 3.14159f / 180;
		float x = smaller_black_radius * cos(angle); // Adjust x-coordinate to fit within the rectangle
		float y = 5 * smaller_black_radius * sin(angle); // Adjust y-coordinate to fit within the rectangle and increase height by 5x
		glVertex2f(x, y);
	}
	glEnd();
	
	// Set the color to green
	glColor3f(0,0.5411764705882353,0.24705882352941178);
	
	// Draw a smaller green circle inside the black circle and fill it
	glBegin(GL_POLYGON);
	float smaller_green_radius = 0.25f * smaller_black_radius; // 35% of the black circle radius
	for (int i = 0; i < 360; ++i) {
		float angle = i * 3.14159f / 180;
		float x = smaller_green_radius * cos(angle); // Adjust x-coordinate
		float y = 5 * smaller_green_radius * sin(angle); // Adjust y-coordinate to fit within the rectangle and increase height by 5x
		glVertex2f(x, y);
	}
	glEnd();
	
	glFlush();
}

void init() {
	glClearColor(1.0, 1.0, 1.0, 1.0); // Set background color to white
	glMatrixMode(GL_PROJECTION);
	glLoadIdentity();
	gluOrtho2D(-1.5, 1.5, -5.0, 5.0); // Set the viewing area
}

int main(int argc, char** argv) {
	glutInit(&argc, argv);
	glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
	glutInitWindowSize(400, 800); // Set window size
	glutCreateWindow("Nested Rectangles");
	init();
	glutDisplayFunc(display);
	glutMainLoop();
	return 0;
}

